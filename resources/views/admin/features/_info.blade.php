<x-alert type="error" id="alert_feature" />
<form id="form_feature">
    @csrf
    <x-input type="hidden" name="id" :value="$feature->id ?? ''" />
    <x-input type="hidden" name="parent_code" :value="$feature->parent_code ?? $parent_code" />
    <x-form-group caption="Name">
        <x-input name="name" :value="$feature->name ?? ''" />
    </x-form-group>
    <x-form-group caption="Url">
        <x-input name="url" :value="$feature->url ?? ''" />
    </x-form-group>
    <x-form-group caption="Icon">
        <x-input name="icon" :value="$feature->icon ?? ''" />
    </x-form-group>
    <button class="btn btn-primary" type="submit">Save</button>
    <button class="btn btn-light ml-2" type="button" onclick="init_feature()">Cancel</button>
    @if(!empty($feature))
        <button class="btn btn-success float-right" type="button" onclick="info_feature('', '{{ $feature->code }}')">Add New Sub</button>
        <div class="flearfix mt-3">
            <button class="btn btn-light" type="button" onclick="reposition({{ $feature->id }}, 'up')">Up</button>
            <button class="btn btn-light ml-2" type="button" onclick="reposition({{ $feature->id }}, 'down')">Down</button>
            <button class="btn btn-danger float-right" type="button" onclick="delete_feature({{ $feature->id }})">Delete</button>
        </div>
    @endif
</form>

<script>
    $form_feature = $('#form_feature');
    $form_feature.submit((e) => {
        e.preventDefault();
        let data = new FormData($form_feature.get(0));
        $.ajax({
            url: "{{ route('admin.features.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                init_feature();
            },
        }).fail((xhr) => {
            handle_error(xhr);
        });
    });

    delete_feature = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                $.post("{{ route('admin.features.delete') }}", {
                    _token, id
                }, () => {
                    init_feature();
                }).fail((xhr) => {
                    handle_error(xhr);
                });
            }
        })
    }

    reposition = (id, direction) => {
        $.post("{{ route('admin.features.reposition') }}", {
            _token, id, direction
        }, () => {
            init_feature();
        }).fail((xhr) => {
            handle_error(xhr);
        });
    }

    handle_error = (xhr) => {
        let error = JSON.parse(xhr.responseText);
        if (error.errors) {
            display_error('alert_feature', error.errors);
        } else {
            console.log(xhr.responseText);
        }
    }

    init_form_element();
    @if(empty($feature))
        $('#password').attr('required', 'required');
        $('#password_confirmation').attr('required', 'required');
    @endif
</script>
