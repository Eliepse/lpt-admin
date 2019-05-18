<?php
use \Illuminate\Support\Arr;
/**
 * @var \Illuminate\Contracts\Support\MessageBag $errors
 * @var string $name
 * @var string $title
 * @var string $type
 * @var string $describedby
 * @var mixed $default
 */

$type = $type ?? 'radio';
$isInvalid = $errors->has($name);
$old = old($name, $default ?? null);

if (!function_exists('optionChecked')) {
    function optionChecked($val, $old, $type): bool
    {
        if (!isset($old) && $old === null)
            return false;

        if ($type === 'radio')
            return $old === $val;

        return !empty(Arr::first($old, function ($el) use ($val) {
            return $el === $val;
        }));
    }
}
?>

<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $title }}</label>
    @if(!empty($description))<p class="text-muted">{{ $description }}</p>@endif

    <div class="selectgroup w-100">
        @foreach($options as $o_name => $o_value)
            <label class="selectgroup-item bg-white">
                <input type="{{ $type }}" name="{{ $name }}" value="{{ $o_value }}"
                       @if(optionChecked($o_value, $old, $type)) checked @endif
                       autocomplete=""
                       class="selectgroup-input {{ $isInvalid ? 'is-invalid' : '' }}">
                <span class="selectgroup-button">{!! $o_name !!}</span>
            </label>
        @endforeach
    </div>

    @if($isInvalid)
        @foreach($errors->get($name) as $message)
            <div class="invalid-feedback">{{ $message }}</div>
        @endforeach
    @endif
</div>

<?php
unset($type);
unset($isInvalid);
unset($old);
?>
