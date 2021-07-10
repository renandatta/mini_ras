@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 id="page_title">Location</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_location()" id="button_new">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_location"></div>
            <form id="search_location" class="mb-2">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <x-input name="name" prefix="search_" caption="Search" />
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <div id="table_location"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $page_title = $('#page_title');
        let $info_location = $('#info_location'),
            $table_location = $('#table_location'),
            $search_location = $('#search_location'),
            $button_new = $('#button_new');

        let search_locations = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($search_location);
            data.paginate = paginate;
            $.post("{{ route('shipper.locations.search') }}?page=" + selected_page, data, (result) => {
                $table_location.html(result);
            }).fail((xhr) => {
                $table_location.html(xhr.responseText);
            });
        }

        let info_location = (id = '') => {
            $search_location.hide();
            $table_location.hide();
            $button_new.hide();
            $page_title.html((id === '' ? 'New' : 'Edit') + ' Location');
            $.post("{{ route('shipper.locations.info') }}", {
                _token, id
            }, (result) => {
                $info_location.html(result);
            }).fail((xhr) => {
                $info_location.html(xhr.responseText);
            });
        }

        let init_location = () => {
            search_locations(selected_page);
            $info_location.html('');
            $page_title.html('Location');
            $info_location.html('');
            $table_location.show();
            $search_location.show();
            $button_new.show();
        }

        $search_location.submit((e) => {
            e.preventDefault();
            search_locations();
        });

        init_form_element();
        init_location();
    </script>
@endpush
