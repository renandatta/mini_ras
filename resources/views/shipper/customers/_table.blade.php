<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($customers->currentPage()-1) * $customers->perPage()) + 1)
        @endif
        @foreach($customers as $customer)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $customer->name }}</td>
                <td class="text-nowrap">{{ $customer->no_id }}</td>
                <td class="text-nowrap">{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td class="text-nowrap py-0 text-center">
                    @if($customer->photo != '')
                        <img src="{{ asset('assets/' . $customer->photo) }}" alt="" class="img-fluid" style="height: 40px;">
                    @endif
                </td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_customer({{ $customer->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $customers->links('vendor.pagination.custom', ['function' => 'search_customers']) }}
@endif
