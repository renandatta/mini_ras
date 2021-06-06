<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>No.ID</th>
            <th>Phone</th>
            <th>Address</th>
            <th class="text-center" width="5%">Photo</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($drivers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($drivers->currentPage()-1) * $drivers->perPage()) + 1)
        @endif
        @foreach($drivers as $driver)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $driver->name }}</td>
                <td class="text-nowrap">{{ $driver->no_id }}</td>
                <td class="text-nowrap">{{ $driver->phone }}</td>
                <td class="text-nowrap">{{ $driver->address }}</td>
                <td class="text-nowrap py-0 text-center">
                    <img src="{{ asset('assets/' . $driver->photo) }}" alt="" class="img-fluid" style="height: 40px;">
                </td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_driver({{ $driver->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($drivers instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $drivers->links('vendor.pagination.custom', ['function' => 'search_drivers']) }}
@endif
