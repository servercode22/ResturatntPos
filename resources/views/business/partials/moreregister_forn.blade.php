@extends('layouts.auth2')
@section('title', __('lang_v1.register'))

@section('content')
<div class="login-form col-md-12 col-xs-12 right-col-content-register">
    <div class="  col-md-12" style="background-color:#565c67">
    
    <p class="form-header text-white">@lang('business.register_mac_address')</p>
    
    

<form action="/business/addmacaddress" method="post">
    @csrf;
  <div class="col-md-5 mb-10">
    <label  class="form-label">@lang('business.serial_key')*</label>
    <input type="text" name="serialkey"class="form-control" placeholder="Serial Key">
    
  </div>
  <div class="col-md-6 mb-10">
    <label  class="form-label">@lang('business.ip_address')</label>
    <input readonly type="text" name="macaddress" class="form-control" value="<?php echo $macAddr?>">
  </div>

  <div class="col-md-5 mt-10">
    
    <label  class="form-label">@lang('business.customer_name')*</label>
    <input type="text" class="form-control" name="customename" placeholder="Customer Name">
    
    
  </div>
  <div class="col-md-6 mt-10">
    <div class="form-group">
    {!! Form::label('start_date', __('business.start_date') . ':') !!}
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </span>
        {!! Form::text('start_date', null, ['class' => 'form-control start-date-picker','placeholder' => __('business.start_date'), 'readonly']); !!}
    </div>
    </div>
</div>
  <div class="col-md-12 mb-10">
        <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
</div>
      


                            

        
    
</div>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('business.getRegister') }}?lang=" + $(this).val();
        });
    })
</script>
@endsection