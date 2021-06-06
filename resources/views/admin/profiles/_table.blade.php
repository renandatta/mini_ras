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
        @if($profiles instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($profiles->currentPage()-1) * $profiles->perPage()) + 1)
        @endif
        @foreach($profiles as $profile)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $profile->name }}</td>
                <td class="text-nowrap">{{ $profile->phone }}</td>
                <td class="text-nowrap">{{ $profile->address }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_profile({{ $profile->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($profiles instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $profiles->links('vendor.pagination.custom', ['function' => 'search_profiles']) }}
@endif
