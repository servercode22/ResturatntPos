@extends('layouts.app')
@section('title', __( 'Kitchen-performance' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Kitchen Performance
    </h1>
</section>

<!-- Main content -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('ssr_location_id',  __('purchase.business_location') . ':') !!}
                        {!! Form::select('ssr_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div> -->

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('service_staff_id',  __('restaurant.service_staff') . ':') !!}
                        {!! Form::select('service_staff_id', $waiters, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all'),'id' => 'location']); !!}
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('ssr_date_range', __('report.date_range') . ':') !!}
                        {!! Form::text('date_range', @format_date('first day of this month') . ' ~ ' . @format_date('last day of this month'), ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'ssr_date_range', 'readonly']); !!}
                    </div>
                </div> -->
            @endcomponent 
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#ss_orders_tab" data-toggle="tab" aria-expanded="true">@lang('restaurant.orders')</a>
                    </li>

                    {{-- <li>
                        <a href="#ss_line_orders_tab" data-toggle="tab" aria-expanded="true">@lang('lang_v1.line_orders')</a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="ss_orders_tab">
                        {{-- @include('report.partials.time_report') --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="kitchen_performance_report">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.date')</th>
                                        <th>@lang('location')</th>
                                        <th>@lang('sale.invoice_no')</th>
                                        <th>@lang('Product name')</th>
                                        <th>@lang('Service Type')</th>

                                        <th>@lang('restaurant.service_staff')</th>
                                        <th>@lang('Cooking  Time')</th>
                                        <th>@lang(' Remaning Time')</th>
                                        <th>@lang('Time Taken')</th>
                                    </tr>
                                </thead>
                                <tbody id="serach_tbl">
                                   
 
                                    @foreach ($sell_details as $sell)
                                    
                                        <tr>
                                            <td>{{$sell->transaction_date}}</td>
                                            <td>{{$sell->location_id}}</td>
                                            <td>{{$sell->transaction_invoiceno}}</td>
                                            <td>{{$sell->product_name}}</td>
                                            <td>{{$sell->name}}</td>

                                            <td>{{$sell->fname}}</td>
                                            <td>{{$sell->product_time}}</td>
                                            <td>{{$sell->update_time }}</td>
                                            <td>{{$sell->cooked_time}}</td>    
                                        </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')
    
  <script>
      $(document).ready(function() {
    $('#kitchen_performance_report').DataTable( {
        
    } );
    $("#location").change(function(){
    var location=$(this).val();
    
    $.ajax({
        url:"/reports/Kitchen-Performance",
        type:"GET",
        data:{'location':location},
        success:function(data){
            var seldetals=data.selldetails;
           
            // console.log(data.selldetails);
            var html='';
            if(seldetals.length > 0){
                for(let i =0;i<seldetals.length;i++){
                    html+='<tr>\
                            <td>'+seldetals[i]['transaction_date']+'</td>\
                            <td>'+seldetals[i]['location_id']+'</td>\
                            <td>'+seldetals[i]['transaction_invoiceno']+'</td>\
                            <td>'+seldetals[i]['product_name']+'</td>\
                            <td>'+seldetals[i]['name']+'</td>\
                            <td>'+seldetals[i]['fname']+'</td>\
                            <td>'+seldetals[i]['product_time']+'</td>\
                            <td>'+seldetals[i]['update_time']+'</td>\
                            <td>'+seldetals[i]['cooked_time']+'</td>\
                            </tr>';
                }

            }
            else{
                    html+='<tr>\
                    <td colspan="9" class="text-center">No Record Found</td>\
                    </tr>'
            }
            $("#serach_tbl").html(html);
        }

    })
  });

} );

  </script>
@endsection

