<div class="form-group {{ $groupclass }}"
     id="{{ $id != '' ? 'form_group_'.$id : '' }}">
    <label for="{{ $id }}">{{ $caption }}</label>
    {{ $slot }}
</div>
