<?php
/**
 * @var \Illuminate\Contracts\Support\MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $type
 * @var string $describedby
 * @var string $placeholder
 */
?>
<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $title }}</label>
    @isset($description)<p class="text-muted">{{ $description }}</p>@endisset

    <select class="form-control custom-select {{ $errors->has($name) ? 'is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            @foreach($attrs ?? [] as $attr => $val) {{ "$attr=\"$val\"" }} @endforeach
            autocomplete="">
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" @if($option['value'] === old($name, $default ?? null)) selected @endif>{{ $option['name'] }}</option>
        @endforeach
    </select>

    @error($name)
    @foreach($errors->get($name) as $message)
        <div class="invalid-feedback">{{ $message }}</div>
    @endforeach
    @enderror
</div>