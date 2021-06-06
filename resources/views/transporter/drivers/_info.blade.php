<x-alert type="error" id="alert_driver" />
<form id="form_driver">
    @csrf
    <x-input type="hidden" name="id" :value="$driver->id ?? ''" />
    <div class="row">
        <div class="col-md-6">
            <x-form-group caption="Name">
                <x-input name="name" :value="$driver->name ?? ''" />
            </x-form-group>
            <x-form-group caption="No.ID">
                <x-input name="no_id" :value="$driver->no_id ?? ''" />
            </x-form-group>
            <x-form-group caption="Phone">
                <x-input name="phone" :value="$driver->phone ?? ''" />
            </x-form-group>
            <x-form-group caption="Address">
                <x-textarea name="address" :value="$driver->address ?? ''" />
            </x-form-group>
        </div>
        <div class="col-md-4">
            <x-form-group caption="Photo">
                <x-input
                    name="photo_driver" type="file" class="dropify" data-height="265"
                    data-allowed-file-extensions="png jpg jpeg" accept="image/jpeg, image/png"
                    :data-default-file="(!empty($driver) && $driver->photo != '') ? $driver->photo_file : ''"
                />
            </x-form-group>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_driver()">Cancel</button>
    @if(!empty($driver))
        <button class="btn btn-danger float-right" type="button" onclick="delete_driver({{ $driver->id }})">Delete</button>
    @endif
</form>
<hr>

<script>
    $form_driver = $('#form_driver');
    $form_driver.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_driver.get(0));
        $.ajax({
            url: "{{ route('transporter.drivers.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_driver();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_driver = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('transporter.drivers.delete') }}", {
                    _token, id
                }, () => {
                    init_driver();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_driver', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
</script>
