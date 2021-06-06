<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Description</th>
            <th class="text-right">Credential</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($user_roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($user_roles->currentPage()-1) * $user_roles->perPage()) + 1)
        @endif
        @foreach($user_roles as $user_role)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $user_role->name }}</td>
                <td>{{ $user_role->description }}</td>
                <td class="text-right">{{ $user_role->feature->name ?? 'Empty' }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_user_role({{ $user_role->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($user_roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $user_roles->links('vendor.pagination.custom', ['function' => 'search_user_roles']) }}
@endif
