<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($profiles->currentPage()-1) * $profiles->perPage()) + 1)
        @foreach($profiles as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->name }}</td>
                <td class="text-nowrap">{{ $value->phone }}</td>
                <td class="text-nowrap">{{ $value->address }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="profile_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $profiles->links('vendor.pagination.custom', ['function' => 'search_profile']) }}
