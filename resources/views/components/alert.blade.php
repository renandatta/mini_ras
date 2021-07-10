<div
    class="alert {{ $type == 'error' ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show"
    role="alert"
    id="{{ $id }}"
    @if($display == false) style="display: none;" @endif
    {{ $attributes }}>
    <div id="{{ $id }}_content">{{ $slot }}</div>
    <button type="button" class="close" onclick="toggle_alert('{{ $id }}')">
        <span aria-hidden="true">×</span>
    </button>
</div>
