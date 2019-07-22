<?php

use Illuminate\Contracts\Support\MessageBag;

/**
 * @var MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $type
 * @var string $describedby
 * @var string $placeholder
 * @var string $default
 */

$defaults = [old($name[0], $default[0] ?? null), old($name[1], $default[1] ?? null)];
?>

<div class="form-group">
    <label class="form-label">{{ $title }}</label>
    @isset($description)<p class="text-muted">{{ $description }}</p>@endisset

<!--suppress CheckEmptyScriptTag -->
    <date-period-input
            :names='@json($name)'
            :defaults='@json( $defaults )'
            @isset($required) :required='true' @endisset
            @isset($placeholder) :placeholder='{{ $placeholder }}' @endisset
            :classes='@json([ $errors->has($name[0]) ? 'is-invalid' : '' ])'
    />

    @error($name[0])
    @foreach($errors->get($name[0]) as $message)
        <div class="invalid-feedback">{{ $message }}</div>
    @endforeach
    @enderror

    @error($name[0])
    @foreach($errors->get($name[0]) as $message)
        <div class="invalid-feedback">{{ $message }}</div>
    @endforeach
    @enderror
</div>