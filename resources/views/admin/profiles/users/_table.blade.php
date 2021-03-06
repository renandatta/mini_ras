<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Role</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @php($no = 1)
        @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($users->currentPage()-1) * $users->perPage()) + 1)
        @endif
        @foreach($users as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $user->name }}</td>
                <td class="text-nowrap">{{ $user->email }}</td>
                <td class="text-nowrap">{{ $user->user_role->name }}</td>
                <td class="py-0 vertical-middle text-right text-nowrap">
                    <button
                        class="btn btn-xs btn-icon-append btn-success"
                        onclick="info_user({{ $user->id }})"
                    >Edit</button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="p-1" colspan="5">
                <button class="btn btn-block btn-primary btn-xs" onclick="info_user()">Add New User</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
@if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $users->links('vendor.pagination.custom', ['function' => 'search_users']) }}
@endif
