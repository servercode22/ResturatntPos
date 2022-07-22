<div class="countdown"></div>

<table class="table bg-gray">
        <tr class="bg-green">
        <th>#</th>
        <th>{{ __('sale.product') }}</th>
        @if( session()->get('business.enable_lot_number') == 1)
            <th>{{ __('lang_v1.lot_n_expiry') }}</th>
        @endif
        @if($sell->type == 'sales_order')
            <th>@lang('lang_v1.quantity_remaining')</th>
        @endif
        <th>{{ __('sale.qty') }}</th>
        @if(!empty($pos_settings['inline_service_staff']))
            <th>
                @lang('restaurant.service_staff')
            </th>
        @endif
        <th>{{ __('sale.unit_price') }}</th>
        <th>{{ __('sale.discount') }}</th>
        <th>{{ __('sale.tax') }}</th>
        <th>{{ __('sale.price_inc_tax') }}</th>
        <th>Cooked time</th>
        <th>{{ __('sale.subtotal') }}</th>
        <th>Action</th>
        <th>Complete</th>
        {{-- <th>update time</th> --}}
    </tr>
    @foreach($sell->sell_lines as $sell_line)
    <?php
    // dd($sell_line->update_time );
    ?>
        <tr data-id="{{$loop->iteration}}">
            <td >{{ $loop->iteration }}</td>
            <td>
                {{ $sell_line->product->name }}
                @if( $sell_line->product->type == 'variable')
                - {{ $sell_line->variations->product_variation->name ?? ''}}
                - {{ $sell_line->variations->name ?? ''}},
                @endif
                {{ $sell_line->variations->sub_sku ?? ''}}
                @php
                $brand = $sell_line->product->brand;
                @endphp
                @if(!empty($brand->name))
                , {{$brand->name}}
                @endif

                @if(!empty($sell_line->sell_line_note))
                <br> {{$sell_line->sell_line_note}}
                @endif
                @if($is_warranty_enabled && !empty($sell_line->warranties->first()) )
                    <br><small>{{$sell_line->warranties->first()->display_name ?? ''}} - {{ @format_date($sell_line->warranties->first()->getEndDate($sell->transaction_date))}}</small>
                    @if(!empty($sell_line->warranties->first()->description))
                    <br><small>{{$sell_line->warranties->first()->description ?? ''}}</small>
                    @endif
                @endif

                @if(in_array('kitchen', $enabled_modules))
                    <br><span class="label @if($sell_line->res_line_order_status == 'cooked' ) bg-red @elseif($sell_line->res_line_order_status == 'served') bg-green @else bg-light-blue @endif">@lang('restaurant.order_statuses.' . $sell_line->res_line_order_status) </span>
                @endif
            </td>
            @if( session()->get('business.enable_lot_number') == 1)
                <td>{{ $sell_line->lot_details->lot_number ?? '--' }}
                    @if( session()->get('business.enable_product_expiry') == 1 && !empty($sell_line->lot_details->exp_date))
                    ({{@format_date($sell_line->lot_details->exp_date)}})
                    @endif
                </td>
            @endif
            @if($sell->type == 'sales_order')
                <td><span class="display_currency" data-currency_symbol="false" data-is_quantity="true">{{ $sell_line->quantity - $sell_line->so_quantity_invoiced }}</span> @if(!empty($sell_line->sub_unit)) {{$sell_line->sub_unit->short_name}} @else {{$sell_line->product->unit->short_name}} @endif</td>
            @endif
            <td>
                <span class="display_currency" data-currency_symbol="false" data-is_quantity="true">{{ $sell_line->quantity }}</span> @if(!empty($sell_line->sub_unit)) {{$sell_line->sub_unit->short_name}} @else {{$sell_line->product->unit->short_name}} @endif
            </td>
            @if(!empty($pos_settings['inline_service_staff']))
                <td>
                {{ $sell_line->service_staff->user_full_name ?? '' }}
                </td>
            @endif
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->unit_price_before_discount }}</span>
            </td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->get_discount_amount() }}</span> @if($sell_line->line_discount_type == 'percentage') ({{$sell_line->line_discount_amount}}%) @endif
            </td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->item_tax }}</span> 
                @if(!empty($taxes[$sell_line->tax_id]))
                ( {{ $taxes[$sell_line->tax_id]}} )
                @endif
            </td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->unit_price_inc_tax }}</span>
            </td>
            {{-- timer add --}}
            <td >
                <span  class="countdown"  id="demo">
                <?php
                     
                if($sell_line->update_status!=0){
                       echo $sell_line->update_time;
                }else{
                   echo  $sell_line->product->time;
                }
                    ?>
                </span>
            </td>
            <td>
                <span class="display_currency" data-currency_symbol="true">{{ $sell_line->quantity * $sell_line->unit_price_inc_tax }}</span>
            </td>
            <td>
                <span><button  id="cookeed"  data-id=" {{$loop->iteration }}" >Start Cooking</button></span>
            </td>
            <td>
                <input type="checkbox"   id="checked" name="checked" value="{{ $sell_line->product->id}}" data-id=" {{$loop->iteration }}" data-name="{{$sell_line->transaction_id}}" data-time="{{$sell_line->product->time}}" >
                        <label for="checked"> Cooked</label>
            </td>
            {{-- <td>
                <span>
                    {{$sell_line->product->update_time}}
 
                </span>
            </td> --}}
        </tr>
        @if(!empty($sell_line->modifiers))
        @foreach($sell_line->modifiers as $modifier)
            <tr>
                <td>&nbsp;</td>
                <td>
                    {{ $modifier->product->name }} - {{ $modifier->variations->name ?? ''}},
                    {{ $modifier->variations->sub_sku ?? ''}}
                </td>
                @if( session()->get('business.enable_lot_number') == 1)
                    <td>&nbsp;</td>
                @endif
                <td>{{ $modifier->quantity }}</td>
                @if(!empty($pos_settings['inline_service_staff']))
                    <td>
                        &nbsp;
                    </td>
                @endif
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{ $modifier->unit_price }}</span>
                </td>
                <td>
                    &nbsp;
                </td>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{ $modifier->item_tax }}</span> 
                    @if(!empty($taxes[$modifier->tax_id]))
                    ( {{ $taxes[$modifier->tax_id]}} )
                    @endif
                </td>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{ $modifier->unit_price_inc_tax }}</span>
                </td>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{ $modifier->quantity * $modifier->unit_price_inc_tax }}</span>
                </td>
                
            </tr>
            

            @endforeach
        @endif
    @endforeach
</table>
<script>

// time java script
$(document).ready(function(){

    $(document).on('click','#cookeed',function(){
        var ge=$(this).attr('data-id');
        ge = parseInt(ge);
     
        var trtag=$(this).closest('tr');
        
        var table=trtag.find('#demo').text();
        var arr=table.split(":");
        var hours=arr[0];
        var minutes=arr[1];
        var seconds=arr[2];

var convertminutes=minutes*60;
var convertsec=seconds*1;
var time=convertminutes+convertsec;


       var mytimer =     setInterval(function (){
                                    const h=Math.floor(time/3600);
                                    const min= Math.floor(time/60);
                                    const s=Math.floor(time%60);
                                    
                                    // if(counter>=0){
                                        time--;

                                        var a= document.getElementsByClassName("countdown")[ge]
                                        
                                       a.innerHTML=`${h} : ${min} : ${s}`;
                                    

                                        
                                    // }
                                     $(document).on('click','#checked',function(){
                            var get=$(this).attr('data-id');
                            get= parseInt(get);

                            var gut=$(this).attr('data-name');
                            var value=$(this).val();
                            var firsttime=$(this).attr('data-time');
                            var arrr=firsttime.split(":");
                            var hours=arrr[0];
                            var minutes=arrr[1];
                            var seconds=arrr[2];
                            
                            var convertminutes=minutes*60;
                            // alert(convertminutes)
                            var convertsec=seconds*1;
                            var timetaken=convertminutes+convertsec;
                            
                          
                            
                            var lasttr=$(this).closest('tr');
                            var last=lasttr.find('#demo').text()
                            var last1=lasttr.find('#demo').text()
                                console.log(timetaken);
                                console.log(time)
                                var totaltime=(timetaken-time);
                                console.log(totaltime);
                                const ho=Math.floor(totaltime/3600);
                                    const mi= Math.floor(totaltime/60);
                                    const ss=Math.floor(totaltime%60);
                                    a=`${ho} : ${mi} : ${ss}`;
                              console.log(a); 
                            
                                
                            if (get==ge) 
                            {
                            clearInterval(mytimer);
                            


                            }

                            $.ajax({
                                type: "get",
                                url:  '/time/'+ last + '/' + gut + '/'+value+'/'+a ,
                               success:function(data){

                               }

                            })
                            

                        }); 
                                    
                        },1000);
                      
                        
                        
        
    });
    
  
})


</script>

   
       

