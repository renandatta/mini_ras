<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Profile</th>
        <th>Vehicle</th>
        <th>No.Order</th>
        <th>Date</th>
        <th>Arrived Date</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($delivery_orders->currentPage()-1) * $delivery_orders->perPage()) + 1)
        @foreach($delivery_orders as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->vehicle->profile->name ?? '' }}</td>
                <td class="text-nowrap">{{ $value->vehicle->name_complete ?? '' }}</td>
                <td class="text-nowrap">{{ $value->no_order }}</td>
                <td class="text-nowrap">{{ format_date($value->date) }}</td>
                <td class="text-nowrap">{{ format_date($value->arrived_date) }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="delivery_order_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $delivery_orders->links('vendor.pagination.custom', ['function' => 'search_delivery_order']) }}
