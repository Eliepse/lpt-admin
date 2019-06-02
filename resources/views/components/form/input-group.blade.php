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
    <label class="form-label" for="{{ $name }}">{{ $title ?? '' }}</label>
    @isset($description)<p class="text-muted">{{ $description }}</p>@endisset

    <div class="input-group">
        {!! $before ?? '' !!}
        <input type="{{ $type ?? 'text' }}" id="{{ $name }}" name="{{ $name }}"
               class="form-control @error($name) is-invalid @enderror {{ $classes ?? '' }}"
               @isset($placeholder)placeholder="{{ $placeholder }}" @endisset
               autocomplete
               @if($required ?? false) required @endif
               @foreach($attrs ?? [] as $attr => $val) {{ "$attr=\"$val\"" }} @endforeach
               value="{{ old($name, $default ?? '') }}">
        {!! $after ?? '' !!}
    </div>

    @error($name)
    @foreach($errors->get($name) as $message)
        <div class="invalid-feedback">{{ $message }}</div>
    @endforeach
    @enderror
</div>