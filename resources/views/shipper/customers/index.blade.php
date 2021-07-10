@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 id="page_title">Customer</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" onclick="info_customer()" id="button_new">Add New</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="info_customer"></div>
            <form id="search_customer" class="mb-2">
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
            <div id="table_customer"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10, selected_page = 1;
        let $page_title = $('#page_title');
        let $info_customer = $('#info_customer'),
            $table_customer = $('#table_customer'),
            $search_customer = $('#search_customer'),
            $button_new = $('#button_new');

        let search_customers = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($search_customer);
            data.paginate = paginate;
            $.post("{{ route('shipper.customers.search') }}?page=" + selected_page, data, (result) => {
                $table_customer.html(result);
            }).fail((xhr) => {
                $table_customer.html(xhr.responseText);
            });
        }

        let info_customer = (id = '') => {
            $search_customer.hide();
            $table_customer.hide();
            $button_new.hide();
            $page_title.html((id === '' ? 'New' : 'Edit') + ' Customer');
            $.post("{{ route('shipper.customers.info') }}", {
                _token, id
            }, (result) => {
                $info_customer.html(result);
            }).fail((xhr) => {
                $info_customer.html(xhr.responseText);
            });
        }

        let init_customer = () => {
            search_customers(selected_page);
            $page_title.html('Customer');
            $info_customer.html('');
            $table_customer.show();
            $search_customer.show();
            $button_new.show();
        }

        $search_customer.submit((e) => {
            e.preventDefault();
            search_customers();
        });

        init_form_element();
        init_customer();
    </script>
@endpush
