@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
    </div>
    <div class="card">
        <div class="card-body">
            {!! Form::open(['url' => $type, 'method' => 'post', 'id' => 'payment_log', 'files'=> true]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('invoice_id') ? 'has-error' : '' }}">
                        {!! Form::label('invoice_id', trans('invoice.invoice_number'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('invoice_id', $invoices, null, ['id'=>'invoice_id', 'class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('invoice_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                        {!! Form::label('payment_date', trans('invoice.payment_date'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('payment_date', null, ['class' => 'form-control date']) !!}
                            <span class="help-block">{{ $errors->first('payment_date', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                        {!! Form::label('payment_method', trans('invoice.payment_method'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('payment_method', $payment_methods, null, ['id'=>'payment_method', 'class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('payment_method', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('payment_received') ? 'has-error' : '' }}">
                        {!! Form::label('payment_received', trans('invoice.payment_received'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('payment_received', null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('payment_received', ':message') }}</span>
                            <small class="text-danger" id='message'></small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Actions -->
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-success"><i
                                class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                    <a href="{{ url($type) }}" class="btn btn-warning"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $("#invoice_id").select2({
                theme:"bootstrap",
                placeholder:"{{trans('invoice.invoice_number')}}"
            });
            $("#payment_method").select2({
                theme:"bootstrap",
                placeholder:"{{trans('invoice.payment_method')}}"
            });
            $("#payment_date").on("dp.change",function(){
                $("#payment_log").bootstrapValidator('revalidateField','payment_date');
            });
            $("#payment_log").bootstrapValidator({
                fields: {
                    invoice_id: {
                        validators: {
                            notEmpty: {
                                message: 'The invoice number field is required.'
                            }
                        }
                    },
                    payment_date: {
                        validators: {
                            notEmpty: {
                                message: 'The payment date field is required.'
                            }
                        }
                    },
                    payment_method: {
                        validators: {
                            notEmpty: {
                                message: 'The payment method field is required.'
                            }
                        }
                    },
                    payment_received: {
                        validators: {
                            notEmpty: {
                                message: 'The amount received field is required.'
                            }
                        }
                    }
                }
            });
        });
        $("#invoice_id").on("change",function(){

            paymentLog($(this).val());
        });
        function paymentLog(id){
            $.ajax({
                type: "GET",
                url: '{{ url('invoices_payment_log/payment_logs')}}',
                data: {'id': id, _token: '{{ csrf_token() }}' },
                success: function (data) {
                    var unPaid = data.unpaid_amount;
                    $("#payment_received").val(unPaid);
                    $("#payment_log").bootstrapValidator('revalidateField','payment_received');
                    $("#payment_received").on("keyup",function(){
                        if($("#payment_received").val() <= unPaid){
                            $("#message").hide();
                            $('button[type="submit"]').prop('disabled',false)
                        }else{
                            $("#message").show();
                            $("#message").text('Your invoice amout is: '+unPaid);
                            $('button[type="submit"]').prop('disabled',true);
                        }
                    });
                }
            });
        }
        $("#message").hide();
    </script>
    @endsection
