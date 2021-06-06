@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Profile</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_profile()">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_profile"></div>
            <div id="table_profile"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $info_profile = $('#info_profile'),
            $table_profile = $('#table_profile');

        let search_profiles = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('admin.profiles.search') }}?page=" + selected_page, {
                _token, paginate
            }, (result) => {
                $table_profile.html(result);
            }).fail((xhr) => {
                $table_profile.html(xhr.responseText);
            });
        }

        let info_profile = (id = '') => {
            $.post("{{ route('admin.profiles.info') }}", {
                _token, id
            }, (result) => {
                $info_profile.html(result);
            }).fail((xhr) => {
                $info_profile.html(xhr.responseText);
            });
        }

        let init_profile = () => {
            search_profiles(selected_page);
            $info_profile.html('');
        }

        init_form_element();
        init_profile();
    </script>
@endpush
