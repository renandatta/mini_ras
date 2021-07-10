<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Delivery Order</th>
        <th>Shipper</th>
        <th>Item</th>
        <th>Pickup / Deliver</th>
        <th>Status</th>
        <th>Pickup</th>
        <th>Loading</th>
        <th>Arrive</th>
        <th>Unloading</th>
        <th width="5%">Action</th>
    </tr>
    </thead>
    <tbody>
    @php($no = 1)
    @if($delivery_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @php($no = (($delivery_orders->currentPage()-1) * $delivery_orders->perPage()) + 1)
    @endif
    @foreach($delivery_orders as $delivery_order)
        <tr>
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $delivery_order->no_order }}</td>
            <td class="text-nowrap">{{ $delivery_order->shipment_order->shipper->name }}</td>
            <td class="text-nowrap">{{ $delivery_order->name }}<br>{{ $delivery_order->qty }} {{ $delivery_order->unit }}</td>
            <td class="vertical-middle text-nowrap py-1">
                <a target="_blank" href="https://www.google.com/maps/dir/{{ $delivery_order->pickup_location->lat }},{{ $delivery_order->pickup_location->lng }}/{{ $delivery_order->deliver_location->lat }},{{ $delivery_order->deliver_location->lng }}">
                    <span class="badge badge-light">Show Direction <br>Pickup-Delivery</span>
                </a>
            </td>
            <td class="vertical-middle py-1">
                @if($delivery_order->status == 'Closed')
                    <a
                        target="_blank"
                        href="{{ asset('assets/' . $delivery_order->finish_attachment) }}"
                        class="btn btn-xs btn-success py-2 px-2">{{ $delivery_order->status }}</a>
                @else
                    {{ $delivery_order->status }}
                @endif
            </td>
            <td class="text-nowrap vertical-middle">{{ $delivery_order->date_pickup }}<br>{{ $delivery_order->time_pickup ?? '' }}</td>
            <td class="text-nowrap vertical-middle">{{ $delivery_order->date_loading ?? '' }}<br>{{ $delivery_order->time_loading ?? '' }}</td>
            <td class="text-nowrap vertical-middle">{{ $delivery_order->date_arrive ?? '' }}<br>{{ $delivery_order->time_arrive ?? '' }}</td>
            <td class="text-nowrap vertical-middle">{{ $delivery_order->date_unloading ?? '' }}<br>{{ $delivery_order->time_unloading ?? '' }}</td>
            <td class="py-0 vertical-middle text-right text-nowrap">
                @if($delivery_order->status == 'Waiting Confirmation')
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="status_delivery_order({{ $delivery_order->id }}, 'Confirmed')"
                    >Accept</button>
                    <button
                        class="btn btn-xs btn-icon-append btn-danger"
                        onclick="status_delivery_order({{ $delivery_order->id }}, 'Rejected')"
                    >Reject</button>
                @endif

                @include('shipper.delivery_orders._date_action')
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($delivery_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $delivery_orders->links('vendor.pagination.custom', ['function' => 'search_delivery_orders']) }}
@endif
