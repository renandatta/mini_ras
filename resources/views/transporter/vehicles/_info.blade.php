<x-alert type="error" id="alert_vehicle" />
<form id="form_vehicle">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <x-input type="hidden" name="id" :value="$vehicle->id ?? ''" />
            <x-form-group caption="Code">
                <x-input name="code" :value="$vehicle->code ?? ''" />
            </x-form-group>
            <x-form-group caption="Name">
                <x-input name="name" :value="$vehicle->name ?? ''" />
            </x-form-group>
            <x-form-group caption="Year">
                <x-input name="year" :value="$vehicle->year ?? ''" />
            </x-form-group>
            <x-form-group caption="Brand">
                <x-input name="brand" :value="$vehicle->brand ?? ''" />
            </x-form-group>
            <x-form-group caption="Tracking Url">
                <x-input name="tracking_url" :value="$vehicle->tracking_url ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-6">
            <x-form-group caption="No. License">
                <x-input name="no_license" class="inputmask" :value="$vehicle->no_license ?? ''" data-inputmask="'mask': 'aa 9999 aaa'"  />
            </x-form-group>
            <x-form-group caption="Date Expired License">
                <x-input name="data_license_expired" class="datepicker" :value="format_date($vehicle->data_license_expired ?? '')" />
            </x-form-group>
            <x-form-group caption="No. Registration">
                <x-input name="no_registration" :value="$vehicle->no_registration ?? ''" />
            </x-form-group>
            <x-form-group caption="Date Expired Tax">
                <x-input name="date_tax_expired" class="datepicker" :value="format_date($vehicle->date_tax_expired ?? '')" />
            </x-form-group>
            <x-form-group caption="Description">
                <x-textarea name="description" :value="$vehicle->description ?? ''" />
            </x-form-group>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_vehicle()">Cancel</button>
    @if(!empty($vehicle))
        <button class="btn btn-danger float-right" type="button" onclick="delete_vehicle({{ $vehicle->id }})">Delete</button>
    @endif
</form>
<hr>

<script>
    init_form_element();

    $form_vehicle = $('#form_vehicle');
    $form_vehicle.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_vehicle.get(0));
        $.ajax({
            url: "{{ route('transporter.vehicles.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_vehicle();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_vehicle = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('transporter.vehicles.delete') }}", {
                    _token, id
                }, () => {
                    init_vehicle();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_vehicle', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
