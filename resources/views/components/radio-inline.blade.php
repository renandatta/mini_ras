<div class="mb-2">
    <p>{{ $caption }}</p>
    @foreach($options as $key => $option)
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input
                    type="radio"
                    class="form-check-input"
                    name="{{ $name }}"
                    id="{{ $prefix.$name.'_'.$key }}"
                    value="{{ $key }}"
                    @if($key == $value) checked @endif
                    {{ $attributes }}
                />
                {{ $option }} <i class="input-frame"></i>
            </label>
        </div>
    @endforeach
</div>
