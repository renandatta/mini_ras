<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Code</th>
            <th>City</th>
            <th>Province</th>
            <th>Lat, Lng</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($locations instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($locations->currentPage()-1) * $locations->perPage()) + 1)
        @endif
        @foreach($locations as $location)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $location->name }}</td>
                <td class="text-nowrap">{{ $location->code }}</td>
                <td class="text-nowrap">{{ $location->city }}</td>
                <td class="text-nowrap">{{ $location->province }}</td>
                <td class="text-nowrap">{{ $location->coordinate }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_location({{ $location->id }})"
                    >Edit</button>
                    <a
                        target="_blank"
                        href="http://maps.google.com/?q={{ $location->coordinate }}"
                        class="btn btn-xs btn-icon-append btn-primary pt-2"
                    >Maps</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($locations instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $locations->links('vendor.pagination.custom', ['function' => 'search_locations']) }}
@endif
