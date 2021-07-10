<x-alert type="error" id="alert_customer" />
<form id="form_customer">
    @csrf
    <x-input type="hidden" name="id" :value="$customer->id ?? ''" />
    <div class="row">
        <div class="col-md-6">
            <x-form-group caption="Name">
                <x-input name="name" :value="$customer->name ?? ''" />
            </x-form-group>
            <x-form-group caption="Phone">
                <x-input name="phone" :value="$customer->phone ?? ''" />
            </x-form-group>
            <x-form-group caption="Address">
                <x-textarea name="address" :value="$customer->address ?? ''" />
            </x-form-group>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_customer()">Cancel</button>
    @if(!empty($customer))
        <button class="btn btn-danger float-right" type="button" onclick="delete_customer({{ $customer->id }})">Delete</button>
    @endif
</form>

<script>
    $form_customer = $('#form_customer');
    $form_customer.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_customer.get(0));
        $.ajax({
            url: "{{ route('shipper.customers.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_customer();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_customer = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('shipper.customers.delete') }}", {
                    _token, id
                }, () => {
                    init_customer();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_customer', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
