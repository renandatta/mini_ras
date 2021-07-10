<table class="table table-bordered">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Delivery Order</th>
        <th>Location</th>
        <th>Status</th>
        <th>Pickup</th>
        <th>Loading</th>
        <th>Arrive</th>
        <th>Loading</th>
        <th width="5%">Action</th>
    </tr>
    </thead>
    <tbody>
    @php($no = 1)
    @if($delivery_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @php($no = (($delivery_orders->currentPage()-1) * $delivery_orders->perPage()) + 1)
    @endif
    @php($no_order = '')
    @foreach($delivery_orders as $delivery_order)
        @if($delivery_order->no_order != $no_order)
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $delivery_order->no_order }}<br>{{ $delivery_order->transporter->name }}</td>
            <td class="vertical-middle text-nowrap">
                <span>
                    {{ $delivery_order->pickup_location->name. ', ' .$delivery_order->pickup_location->city }} <br>
                    {{ $delivery_order->deliver_location->name . ', ' . $delivery_order->deliver_location->city }}
                </span>
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
            <td class="py-1 vertical-middle text-right text-nowrap">

                @if(in_array($delivery_order->status, ['Confirmed', 'Rejected', 'Waiting Confirmation']))
                    <button
                        class="btn btn-xs btn-icon-append btn-light mr-1"
                        onclick="info_delivery_order({{ $delivery_order->id }})"
                    >Edit</button>
                    <button
                        class="btn btn-xs btn-icon-append btn-light"
                        onclick="toggle_items('{{ $delivery_order->no_order }}')"
                        id="button_toggle_{{ $delivery_order->no_order }}"
                    >Show Items</button>
                    <br>
                    <a
                        target="_blank"
                        class="btn btn-xs btn-icon-append btn-light mt-1 pt-2"
                        href="https://www.google.com/maps/dir/{{ $delivery_order->pickup_location->lat }},{{ $delivery_order->pickup_location->lng }}/{{ $delivery_order->deliver_location->lat }},{{ $delivery_order->deliver_location->lng }}"
                    >Show Direction</a>
                @endif

                @include('shipper.delivery_orders._date_action')
            </td>
        @endif
        <tr style="display: none;" class="items-{{ $delivery_order->no_order }}">
            <td class="border-top-0 border-bottom-0"></td>
            <td colspan="8" class="text-nowrap border-0 py-1 vertical-middle">{{ $delivery_order->name }}, {{ $delivery_order->qty }} {{ $delivery_order->unit }}</td>
        </tr>
        @php($no_order = $delivery_order->no_order)
    @endforeach
    </tbody>
</table>
@if($delivery_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $delivery_orders->links('vendor.pagination.custom', ['function' => 'search_delivery_orders']) }}
@endif
