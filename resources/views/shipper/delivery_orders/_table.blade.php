<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>No.Delivery Order</th>
        <th>Date</th>
        <th>Transporter</th>
        <th>Status</th>
        <th class="text-center">Items</th>
        <th class="text-center">Delivery Timeline</th>
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
            <td class="text-nowrap">{{ format_date($delivery_order->date) }}</td>
            <td>{{ $delivery_order->transporter->name }}</td>
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
            <td class="vertical-middle py-1 text-center">
                <button
                    class="btn btn-xs btn-icon-append btn-light"
                    onclick="delivery_order_item('{{ $delivery_order->id }}')"
                >Show Items</button>
            </td>
            <td class="vertical-middle py-1 text-center">
                <button
                    class="btn btn-xs btn-icon-append btn-light"
                    onclick="delivery_order_timeline('{{ $delivery_order->id }}')"
                >Timeline</button>
            </td>
            <td class="py-1 vertical-middle text-right text-nowrap">

                @if(in_array($delivery_order->status, ['Confirmed', 'Rejected', 'Waiting Confirmation']))
                    <button
                        class="btn btn-xs btn-icon-append btn-light mr-1"
                        onclick="info_delivery_order({{ $delivery_order->id }})"
                    >Edit</button>
                @endif
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
@if($delivery_orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $delivery_orders->links('vendor.pagination.custom', ['function' => 'search_delivery_orders']) }}
@endif
