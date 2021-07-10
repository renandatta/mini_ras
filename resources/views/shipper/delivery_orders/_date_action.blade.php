@if($delivery_order->status != 'Rejected' && $delivery_order->status != 'Waiting Confirmation')
    @if($delivery_order->date_loading == '' || $delivery_order->time_loading == '')
        <button
            class="btn btn-xs btn-icon-append btn-success"
            onclick="info_delivery_order({{ $delivery_order->id }}, 'Loading')"
        >Loading</button>
    @elseif($delivery_order->date_arrive == '' || $delivery_order->time_arrive == '')
        <button
            class="btn btn-xs btn-icon-append btn-primary"
            onclick="info_delivery_order({{ $delivery_order->id }}, 'Arrive')"
        >Arrive</button>
    @elseif($delivery_order->date_unloading == '' || $delivery_order->time_unloading == '')
        <button
            class="btn btn-xs btn-icon-append btn-warning"
            onclick="info_delivery_order({{ $delivery_order->id }}, 'Unloading')"
        >Unloading</button>
    @elseif($delivery_order->finish_attachment == '')
        <button
            class="btn btn-xs btn-icon-append btn-success"
            onclick="info_delivery_order({{ $delivery_order->id }}, 'Close')"
        >Close Order</button>
    @endif
@endif
