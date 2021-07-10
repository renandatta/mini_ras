<x-alert type="error" id="alert_customer_location" />
<form id="form_customer_location">
    @csrf
    <x-input type="hidden" name="id" :value="$customer_location->id ?? ''" />
    <x-form-group caption="Name">
        <x-input name="name" :value="$customer_location->name ?? ''" />
    </x-form-group>
    <x-form-group caption="Adresss">
        <x-textarea name="address" :value="$customer_location->address ?? ''" />
    </x-form-group>
    <div class="row">
        <div class="col-md-6">
            <x-form-group caption="City">
                <x-input name="city" :value="$customer_location->city ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-6">
            <x-form-group caption="Province">
                <x-input name="province" :value="$customer_location->province ?? ''" />
            </x-form-group>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-form-group caption="Lat">
                <x-input name="lat" :value="$customer_location->lat ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-6">
            <x-form-group caption="Lng">
                <x-input name="lng" :value="$customer_location->lng ?? ''" />
            </x-form-group>
        </div>
    </div>
    <x-form-group caption="Description">
        <x-textarea name="description" :value="$customer_location->description ?? ''" />
    </x-form-group>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_customer_location()">Cancel</button>
    @if(!empty($customer_location))
        <button class="btn btn-danger float-right" type="button" onclick="delete_customer_location({{ $customer_location->id }})">Delete</button>
    @endif
</form>
<hr>

<script>
    $form_customer_location = $('#form_customer_location');
    $form_customer_location.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_customer_location.get(0));
        $.ajax({
            url: "{{ route('shipper.customers.locations.save', $customer_id) }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_customer_location();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_customer_location = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('shipper.customers.locations.delete', $customer_id) }}", {
                    _token, id
                }, () => {
                    init_customer_location();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_customer_location', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
