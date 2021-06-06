<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Year</th>
            <th>Brand</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($vehicles instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($vehicles->currentPage()-1) * $vehicles->perPage()) + 1)
        @endif
        @foreach($vehicles as $vehicle)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $vehicle->code }}</td>
                <td class="text-nowrap">{{ $vehicle->name }}</td>
                <td class="text-nowrap">{{ $vehicle->year }}</td>
                <td class="text-nowrap">{{ $vehicle->brand }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_vehicle({{ $vehicle->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($vehicles instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $vehicles->links('vendor.pagination.custom', ['function' => 'search_vehicles']) }}
@endif
