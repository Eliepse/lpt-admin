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
        <input type="password" id="{{ $name }}" name="{{ $name }}"
               class="form-control @error($name) is-invalid @enderror {{ $classes ?? '' }}"
               @isset($placeholder)placeholder="{{ $placeholder }}" @endisset
               @if($required ?? false) required @endif
               @foreach($attrs ?? [] as $attr => $val) {{ "$attr=$val" }} @endforeach>
        <div class="input-group-append">
            <button class="x-ray btn btn-outline-secondary" data-x-ray="#{{ $name }}" data-default="hide">
                <span class="x-ray-show" data-x-ray-show><i class="fe fe-eye"></i></span>
                <span class="x-ray-hide" data-x-ray-hide><i class="fe fe-eye-off"></i></span>
            </button>
        </div>
        @error($name)
        @foreach($errors->get($name) as $message)
            <div class="invalid-feedback">{{ $message }}</div>
        @endforeach
        @enderror
    </div>
</div>
