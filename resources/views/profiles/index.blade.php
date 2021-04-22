@extends('layouts.admin')

@section('title')
    Profile -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Profile</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="profile_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="profile_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="profile_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $profile_info = $('#profile_info'),
            $profile_table = $('#profile_table');

        let selected_page = 1;
        search_profile = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if(page.toString() === '-1') selected_page--;
            else selected_page = page

            $.post("{{ route('profiles.search') }}", {_token, paginate}, (result) => {
                $profile_table.html(result);
            }).fail((xhr) => {
                $profile_table.html(xhr.responseText);
            });
        }

        init_profile = () => {
            $profile_info.html('');
            search_profile();
        }

        profile_info = (id = '') => {
            $.post("{{ route('profiles.info') }}", {_token, id}, (result) => {
                $profile_info.html(result);
            }).fail((xhr) => {
                $profile_info.html(xhr.responseText);
            });
        }

        init_profile();
    </script>
@endpush
