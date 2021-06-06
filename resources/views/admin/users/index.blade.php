@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>User</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_user()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_user"></div>
            <div id="table_user"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_user = $('#info_user'),
            $table_user = $('#table_user');

        let search_users = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('admin.users.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_user.html(result);
            }).fail((xhr) => {
                $table_user.html(xhr.responseText);
            });
        }

        let info_user = (id = '') => {
            $.post("{{ route('admin.users.info') }}", {
                _token, id
            }, (result) => {
                $info_user.html(result);
            }).fail((xhr) => {
                $info_user.html(xhr.responseText);
            });
        }

        let init_user = () => {
            search_users(selected_page);
            $info_user.html('');
        }

        init_form_element();
        init_user();
    </script>
@endpush
