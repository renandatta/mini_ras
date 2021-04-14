<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_vehicle" />
        <form id="vehicle_form">
            @csrf
            @if(!empty($vehicle))
                <x-input type="hidden" name="id" :value="$vehicle->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="profile_id" caption="Profile">
                        <x-select
                            name="profile_id"
                            class="select2"
                            caption="-"
                            :options="$profiles"
                            :value="$vehicle->profile_id ?? ''"
                        />
                    </x-form-group>
                    <x-form-group id="code" caption="Code">
                        <x-input name="code" :value="$vehicle->code ?? ''" />
                    </x-form-group>
                    <x-form-group id="name" caption="Name">
                        <x-input name="name" :value="$vehicle->name ?? ''" />
                    </x-form-group>
                    <x-form-group id="tracking_url" caption="Tracking Url">
                        <x-input name="tracking_url" :value="$vehicle->tracking_url ?? ''" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_vehicle()">Cancel</button>
                    @if(!empty($vehicle))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_vehicle({{ $vehicle->id }})">Hapus</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $vehicle_form = $('#vehicle_form');
    $vehicle_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($vehicle_form.get(0));
        $.ajax({
            url: "{{ route('vehicles.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_vehicle();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_vehicle', error.errors);
            } else {
                console.log(xhr.responseText);
            }
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
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('vehicles.delete') }}", data, () => {
                    init_vehicle();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_vehicle', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
