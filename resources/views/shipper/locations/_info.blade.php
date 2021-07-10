<x-alert type="error" id="alert_location" />
<form id="form_location">
    @csrf
    <x-input type="hidden" name="id" :value="$location->id ?? ''" />
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-8">
                    <x-form-group caption="Name">
                        <x-input name="name" :value="$location->name ?? ''" />
                    </x-form-group>
                </div>
                <div class="col-md-4">
                    <x-form-group caption="Code">
                        <x-input name="code" :value="$location->code ?? ''" />
                    </x-form-group>
                </div>
            </div>
            <x-form-group caption="Customer">
                <x-select name="customer_id" class="select2" caption="Kosong" :options="$customer" :value="$location->customer_id ?? ''" />
            </x-form-group>
            <x-form-group caption="Description">
                <x-textarea name="description" :value="$location->description ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-6">
            <x-form-group caption="Adresss">
                <x-textarea name="address" :value="$location->address ?? ''" />
            </x-form-group>
            <div class="row">
                <div class="col-md-6">
                    <x-form-group caption="City">
                        <x-input name="city" :value="$location->city ?? ''" />
                    </x-form-group>
                </div>
                <div class="col-md-6">
                    <x-form-group caption="Province">
                        <x-input name="province" :value="$location->province ?? ''" />
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-form-group caption="Lat">
                        <x-input name="lat" :value="$location->lat ?? ''" />
                    </x-form-group>
                </div>
                <div class="col-md-6">
                    <x-form-group caption="Lng">
                        <x-input name="lng" :value="$location->lng ?? ''" />
                    </x-form-group>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_location()">Cancel</button>
    @if(!empty($location))
        <button class="btn btn-danger float-right" type="button" onclick="delete_location({{ $location->id }})">Delete</button>
    @endif
</form>

<script>
    $form_location = $('#form_location');
    $form_location.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_location.get(0));
        $.ajax({
            url: "{{ route('shipper.locations.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_location();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_location = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('shipper.locations.delete') }}", {
                    _token, id
                }, () => {
                    init_location();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_location', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
