<?php
/**
 * @var \Illuminate\Contracts\Support\MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $describedby
 * @var string $placeholder
 */
$isInvalid = $errors->has($name);
?>

<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $title }}</label>
    @if(!empty($description))<p class="text-muted">{{ $description }}</p>@endif
    <textarea class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" id="{{ $name }}"
              name="{{ $name }}" rows="6" placeholder="{{ $placeholder ?? '' }}"></textarea>
    @if($isInvalid)
        @foreach($errors->get($name) as $message)
            <div class="invalid-feedback">{{ $message }}</div>
        @endforeach
    @endif
</div>

<?php unset($isInvalid); ?>