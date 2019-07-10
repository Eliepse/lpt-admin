<?php
/**
 * @var array $steps
 * @var int $active
 */
?>

<table class="table table-borderless w-100">
    <tbody>
    <tr class="border-bottom border-info text-center" style="vertical-align: bottom;">
        @foreach($steps as $step)
            @if($loop->index === $active ?? null)
                <td class="text-info border-info" style="border-bottom: 3px solid;">
                    <strong>{{ $loop->index + 1 }}. {{ $step }}</strong>
                </td>
            @else
                <td>{{ $loop->index + 1 }}. {{ $step }}</td>
            @endif
        @endforeach
    </tr>
    </tbody>
</table>
