<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Lat, Lng</th>
            <th>Description</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($customer_locations instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($customer_locations->currentPage()-1) * $customer_locations->perPage()) + 1)
        @endif
        @foreach($customer_locations as $customer_location)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $customer_location->name }}</td>
                <td class="text-nowrap">{{ $customer_location->address }}, {{ $customer_location->city }}, {{ $customer_location->province }}</td>
                <td class="text-nowrap">{{ $customer_location->coordinate }}</td>
                <td class="text-nowrap">{{ $customer_location->description }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_customer_location({{ $customer_location->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($customer_locations instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $customer_locations->links('vendor.pagination.custom', ['function' => 'search_customer_locations']) }}
@endif
