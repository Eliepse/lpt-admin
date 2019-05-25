<?php
/**
 * @var \Illuminate\Contracts\Support\MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $describedby
 * @var string $placeholder
 */
?>

<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $title }}</label>
    @if(!empty($description))<p class="text-muted">{{ $description }}</p>@endif
    <textarea class="form-control @error($name) is-invalid @enderror"
              id="{{ $name }}"
              name="{{ $name }}"
              rows="6"
              autocomplete=""
              @if($required ?? false) required @endif
              @foreach($attrs ?? [] as $attr => $val) {{ "$attr=\"$val\"" }} @endforeach
              placeholder="{{ $placeholder ?? '' }}">{{ old($name, $default ?? '') }}</textarea>
    @error($name)
    @foreach($errors->get($name) as $message)
        <div class="invalid-feedback">{{ $message }}</div>
    @endforeach
    @enderror
</div>