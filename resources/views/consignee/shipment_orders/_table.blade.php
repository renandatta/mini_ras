<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>No.Order</th>
            <th>Shipper</th>
            <th>Date</th>
            <th>Item</th>
            <th>Status</th>
            <th>Description</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($shipment_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($shipment_orders->currentPage()-1) * $shipment_orders->perPage()) + 1)
        @endif
        @foreach($shipment_orders as $shipment_order)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $shipment_order->no_order }}</td>
                <td class="text-nowrap">{{ $shipment_order->shipper->name ?? '' }}</td>
                <td class="text-nowrap">{{ format_date($shipment_order->date) }}</td>
                <td class="text-nowrap">
                    @foreach($shipment_order->items as $item)
                        {{ $item->name . ' x ' . $item->qty . ' ' . $item->unit }} <br>
                    @endforeach
                </td>
                <td class="text-nowrap">{{ $shipment_order->status }}</td>
                <td class="text-nowrap">{{ $shipment_order->description }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_shipment_order({{ $shipment_order->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($shipment_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $shipment_orders->links('vendor.pagination.custom', ['function' => 'search_shipment_orders']) }}
@endif
