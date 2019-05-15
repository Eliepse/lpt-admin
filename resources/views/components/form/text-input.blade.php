<?php
/**
 * @var \Illuminate\Contracts\Support\MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $type
 * @var string $describedby
 * @var string $placeholder
 */
$isInvalid = $errors->has($name);
?>

<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $title }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}"
           class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
           id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}">
    @if($isInvalid)
        @foreach($errors->get($name) as $message)
            <div class="invalid-feedback">{{ $message }}</div>
        @endforeach
    @endif
</div>

<?php unset($isInvalid); ?>