 <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab" tabindex="0">
     <div class="cart-section">
         <table>
             <tbody>
                 <tr class="table-row table-top-row">
                     <td class="table-wrapper">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.order_number') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.sub_total') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.shipping_cost') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.vat') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper wrapper-total">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.discount') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper wrapper-total">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.total') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper wrapper-total">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('order.status') }}</h5>
                         </div>
                     </td>
                     <td class="table-wrapper wrapper-total">
                         <div class="table-wrapper-center">
                             <h5 class="table-heading">{{ trans('main.action') }}</h5>
                         </div>
                     </td>
                 </tr>

                 @foreach (auth()->user()->orders as $order)
                     <tr class="table-row ticket-row">

                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">#{{ $order->order_number }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">{{ $order->sub_total }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">{{ $order->shipping_cost }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">{{ $order->vat }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">{{ $order->discount }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <h5 class="heading">{{ $order->total }}</h5>
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 {{ $order->status->name ?? '-' }}
                             </div>
                         </td>
                         <td class="table-wrapper">
                             <div class="table-wrapper-center">
                                 <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success">
                                     {{ trans('main.details') }}
                                 </a>
                                 &nbsp;
                                 <a href="{{ route('orders.invoice', $order->id) }}" target="_blank"
                                     class="btn btn-primary">
                                     {{ trans('main.invoice') }}
                                 </a>
                             </div>
                         </td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
