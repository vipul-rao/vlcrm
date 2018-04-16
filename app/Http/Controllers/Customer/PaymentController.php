<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayRequest;
use App\Repositories\InvoicePaymentRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OrganizationSettingsRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Session;
use Srmklive\PayPal\Facades\PayPal;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /*user site settings*/
    private $invoiceRepository;
    private $invoicePaymentRepository;
    private $organizationSettingsRepository;
    private $userRepository;

    public function __construct(InvoiceRepository $invoiceRepository,
                                InvoicePaymentRepository $invoicePaymentRepository,
                                UserRepository $userRepository,
                                OrganizationSettingsRepository $organizationSettingsRepository)
    {
        parent::__construct();
        $this->invoiceRepository = $invoiceRepository;
        $this->invoicePaymentRepository = $invoicePaymentRepository;
        $this->organizationSettingsRepository = $organizationSettingsRepository;
        $this->userRepository = $userRepository;

        $payment_method = ['stripe' => 'Stripe'];
        view()->share('payment_method', $payment_method);

        view()->share('type', 'payment');
    }

    public function pay($invoice)
    {
        $invoice = $this->invoiceRepository->find($invoice);
        $title = trans('payment.pay_invoice');
        $this->generateParams();
        view()->share('no_vue', true);
        return view('customers/payment.pay', compact('title', 'invoice'));
    }

    public function stripe(Request $request, $invoice)
    {
        $this->generateParams();
        $invoice = $this->invoiceRepository->find($invoice);

        $recive_payment = $this->invoicePaymentRepository->getAll()->count();

        if($recive_payment == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->invoicePaymentRepository->getAll()->last()->id;
        }

        $company_name = isset($invoice->companies)?$invoice->companies->name:null;
        $user = $this->userRepository->getUser();
        $stripe_secret = $this->organizationSettingsRepository->getKey('stripe_secret');
        Stripe::setApiKey($stripe_secret);

        Charge::create(array(
            "amount" => $invoice->unpaid_amount*100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => trans('payment.payment_from').$company_name." by ".$user->full_name
        ));

        $start_number = $this->organizationSettingsRepository->getKey('invoice_payment_start_number');
        $payment_no = $this->organizationSettingsRepository->getKey('invoice_payment_prefix') . ((is_int($start_number)?$start_number:0) + (isset($total_fields) ? $total_fields : 0) + 1);
        $request->merge([
            'invoice_id'=>$invoice->id,
            'payment_date' => date(config('settings.date_format')),
            'payment_method' => 'Stripe',
            'payment_received' => $invoice->unpaid_amount,
            'payment_number'=> $payment_no,
            'paykey'=>$request->stripeToken,
            'company_id'=>$invoice->company_id,
        ]);
        $this->invoicePaymentRepository->createPayment($request->except('stripeToken','stripeTokenType','stripeEmail'));

        $unpaid_amount_new = round($invoice->unpaid_amount - $request->payment_received, 2);

        if ($unpaid_amount_new <= '0') {
            $invoice_data = [
                'unpaid_amount' => $unpaid_amount_new,
                'status' => trans('payment.paid_invoice'),
            ];
        } else {
            $invoice_data = [
                'unpaid_amount' => $unpaid_amount_new,
            ];
        }

        $invoice->update($invoice_data);

        return redirect('customers/payment/success');
    }

    public function paypal(PayRequest $request,$invoice)
    {

        $invoice = $this->invoiceRepository->find($invoice);
        $organizationSettings = $this->organizationSettingsRepository->getAll();
        $this->PaypalConfig();
        $provider = PayPal::setProvider('express_checkout');
        $now = now();
        $data = [];
        $data['items'] = [
            [
                'name' => $invoice->invoice_number,
                'price' => $invoice->unpaid_amount,
                'qty' => 1
            ]
        ];
        $data['subscription_desc'] = $invoice->invoice_number .' - '.$invoice->unpaid_amount.' '.$organizationSettings['currency'] ?? '';
        $data['invoice_id'] = $now;
        $data['invoice_description'] = $invoice->invoice_number .' - '.$invoice->unpaid_amount.' '.$organizationSettings['currency'] ?? '';
        $data['cancel_url'] = url('customers/payment/'.$invoice->id.'/paypal_cancel');
        $data['return_url'] = url('customers/payment/'.$invoice->id.'/paypal_success');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $data['total'] = $total;
        $currency = $organizationSettings['currency']??'USD';
        $response = $provider->setCurrency($currency)->setExpressCheckout($data);
        // if there is no link redirect back with error message
        if (!$response['paypal_link']) {
            return redirect('/')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal']);
            // For the actual error message dump out $response and see what's in there
        }

        // redirect to paypal
        // after payment is done paypal
        // will redirect us back to $this->expressCheckoutSuccess
        return redirect($response['paypal_link']);
    }
    public function paypalSuccess(Request $request,$invoice)
    {
        $invoice = $this->invoiceRepository->find($invoice);
        $organizationSettings = $this->organizationSettingsRepository->getAll();
        $this->PaypalConfig();
        $provider = PayPal::setProvider('express_checkout');
        $token = $request->token;
        $PayerID = $request->PayerID;
        $now = now();
        $data = [];
        $data['items'] = [
            [
                'name' => $invoice->invoice_number,
                'price' => $invoice->unpaid_amount,
                'qty' => 1
            ]
        ];
        $data['subscription_desc'] = $invoice->invoice_number .' - '.$invoice->unpaid_amount.' '.$organizationSettings['currency'] ?? '';
        $data['invoice_id'] = $now;
        $data['invoice_description'] = $invoice->invoice_number .' - '.$invoice->unpaid_amount.' '.$organizationSettings['currency'] ?? '';

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }

        $data['total'] = $total;
        $currency = $organizationSettings['currency']??'USD';
        $response = $provider->setCurrency($currency)->doExpressCheckoutPayment($data, $token, $PayerID);
        if (!isset($response)){
            return $response;
        }


        $start_number = $this->organizationSettingsRepository->getKey('invoice_payment_start_number');
        $payment_no = $this->organizationSettingsRepository->getKey('invoice_payment_prefix') . ((is_int($start_number)?$start_number:0) + (isset($total_fields) ? $total_fields : 0) + 1);
        $request->merge([
            'invoice_id'=>$invoice->id,
            'payment_date' => date(config('settings.date_format')),
            'payment_method' => 'Paypal',
            'payment_received' => $invoice->unpaid_amount,
            'payment_number'=> $payment_no,
            'paykey'=>$token,
            'company_id'=>$invoice->company_id,
        ]);
        $this->invoicePaymentRepository->createPayment($request->except('PayerID','token'));

        $unpaid_amount_new = round($invoice->unpaid_amount - $request->payment_received, 2);

        if ($unpaid_amount_new <= '0') {
            $invoice_data = [
                'unpaid_amount' => $unpaid_amount_new,
                'status' => trans('payment.paid_invoice'),
            ];
        } else {
            $invoice_data = [
                'unpaid_amount' => $unpaid_amount_new,
            ];
        }

        $invoice->update($invoice_data);

        return redirect('customers/payment/success');
    }

    public function success()
    {
        $title = trans('payment.payment_finish');

        return view('customers.payment.success', compact('title'));
    }

    public function cancel()
    {
        return redirect('customers');
    }

    private function generateParams()
    {
        $stripe_publishable = $this->organizationSettingsRepository->getKey('stripe_publishable');
        $stripe_secret = $this->organizationSettingsRepository->getKey('stripe_secret');
        $currency = $this->organizationSettingsRepository->getKey('currency');

        view()->share('stripe_publishable',$stripe_publishable);
        view()->share('stripe_secret', $stripe_secret);
        view()->share('currency', $currency);
    }

    private function PaypalConfig()
    {
        $organizationSettings = $this->organizationSettingsRepository->getAll();
        //Paypal
        config(['paypal.mode' => $organizationSettings['paypal_mode'] ?? null]);
        config(['paypal.sandbox.username' => $organizationSettings['paypal_sandbox_username'] ?? null]);
        config(['paypal.sandbox.password' => $organizationSettings['paypal_sandbox_password'] ?? null]);
        config(['paypal.sandbox.secret' => $organizationSettings['paypal_sandbox_signature'] ?? null]);

        config(['paypal.live.username' => $organizationSettings['paypal_live_username'] ?? null]);
        config(['paypal.live.password' => $organizationSettings['paypal_live_password'] ?? null]);
        config(['paypal.live.secret' => $organizationSettings['paypal_live_signature'] ?? null]);
    }

}
