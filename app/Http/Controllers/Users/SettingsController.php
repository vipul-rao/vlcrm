<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationSettingRequest;
use App\Models\PrintTemplate;
use App\Repositories\OptionRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\OrganizationSettingsRepository;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var OrganizationSettingsRepository
     */
    private $organizationSettingsRepository;
    private $organizationRepository;

    /**
     * SettingsController constructor.
     *
     * @param OptionRepository               $optionRepository
     * @param OrganizationSettingsRepository $OrganizationSettingsRepository
     */
    public function __construct(
        OptionRepository $optionRepository,
        OrganizationSettingsRepository $organizationSettingsRepository,
        OrganizationRepository $organizationRepository
    )
    {
        parent::__construct();

        view()->share('type', 'setting');

        $this->optionRepository = $optionRepository;
        $this->organizationSettingsRepository = $organizationSettingsRepository;
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orgRole = $this->getUser()->orgRole;
        if ('admin' != $orgRole) {
            return redirect('dashboard');
        }
        $title = trans('settings.settings');
        $max_upload_file_size = [
            '1000' => '1MB',
            '2000' => '2MB',
            '3000' => '3MB',
            '4000' => '4MB',
            '5000' => '5MB',
            '6000' => '6MB',
            '7000' => '7MB',
            '8000' => '8MB',
            '9000' => '9MB',
            '10000' => '10MB',
        ];
        $currency = $this->optionRepository->getAll()
            ->where('category', 'currency')
            ->map(
                function ($title) {
                    return [
                        'text' => $title->title,
                        'id' => $title->value,
                    ];
                }
            )->pluck('text', 'id')->toArray();

        $backup_type = $this->optionRepository->getAll()
            ->where('category', 'backup_type')
            ->map(
                function ($title) {
                    return [
                        'text' => $title->value,
                        'id' => $title->title,
                    ];
                }
            );
        $orgSettings = $this->organizationSettingsRepository->getAll();

        $invoice_template = PrintTemplate::where('type', 'invoice')->pluck('name', 'slug')->toArray();
        $saleorder_template = PrintTemplate::where('type', 'saleorder')->pluck('name', 'slug')->toArray();
        $quotation_template = PrintTemplate::where('type', 'quotation')->pluck('name', 'slug')->toArray();

        return view('user.setting.index', compact('title', 'max_upload_file_size', 'currency', 'backup_type',
        'orgSettings', 'invoice_template', 'saleorder_template', 'quotation_template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrganizationSettingRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function update(OrganizationSettingRequest $request)
    {
        $orgRole = $this->getUser()->orgRole;
        if ('admin' != $orgRole) {
            return redirect('dashboard');
        }
        $this->user = $this->getUser();

        if ('' != $request->hasFile('site_logo_file')) {
            $file = $request->file('site_logo_file');
            $file = $this->organizationRepository->uploadLogo($file);

            $request->merge([
                'logo' => $file->getFileInfo()->getFilename(),
            ]);
            $this->organizationRepository->generateThumbnail($file);
        }

        $request->date_format = $request->date_format_custom;
        $request->time_format = $request->time_format_custom;
        if ('' == $request->date_format) {
            $request->date_format = 'd-m-Y';
        }
        if ('' == $request->time_format) {
            $request->time_format = 'H:i';
        }
        $request->merge([
            'date_time_format' => $request->date_format.' '.$request->time_format,
        ]);
        foreach ($request->except('_token', 'pdf_logo_file', 'site_logo_file', 'date_format_custom', 'time_format_custom') as $key => $value) {
            $this->organizationSettingsRepository->setKey($key, $value);
        }

        return redirect()->back();
    }
}
