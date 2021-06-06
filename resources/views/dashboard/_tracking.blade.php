<h5 class="mt-2 float-right text-right"><small>Date</small><br>{{ format_date($delivery_order->date) }}</h5>
<h5 class="mt-2"><small>No.Order</small><br>{{ $delivery_order->no_order }}</h5>
<div class="clearfix"></div>
@if($delivery_order->arrived_date != '')
<h5 class="mt-2 float-right text-right"><small>Arrived Date</small><br>{{ format_date($delivery_order->arrived_date) }}</h5>
@endif
<h5 class="mt-2"><small>Vehicle</small><br>{{ $delivery_order->vehicle->code }} ({{ $delivery_order->vehicle->name }})</h5>
<iframe
    src="{{ $delivery_order->vehicle->tracking_url }}"
    class="w-100 mt-3"
    style="width: 100%;height: 65vh;"
    frameborder="0"
></iframe>
