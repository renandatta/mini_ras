@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>User Role</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_user_role()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_user_role"></div>
            <div id="table_user_role"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_user_role = $('#info_user_role'),
            $table_user_role = $('#table_user_role');

        let search_user_roles = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('admin.user_roles.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_user_role.html(result);
            }).fail((xhr) => {
                $table_user_role.html(xhr.responseText);
            });
        }

        let info_user_role = (id = '') => {
            $.post("{{ route('admin.user_roles.info') }}", {
                _token, id
            }, (result) => {
                $info_user_role.html(result);
            }).fail((xhr) => {
                $info_user_role.html(xhr.responseText);
            });
        }

        let init_user_role = () => {
            search_user_roles(selected_page);
            $info_user_role.html('');
        }

        init_form_element();
        init_user_role();
    </script>
@endpush
