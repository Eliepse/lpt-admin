<?php
/**
 * @var \Eliepse\Charts\DayGantt\GanttDayChart $gantt
 * @var \App\Schedule $schedule
 */

$today = \App\Enums\DaysEnum::getKey(Carbon\Carbon::now()->dayOfWeek);
$gridX = 1;
?>
<div>
    <div class="d-none d-lg-flex border-bottom mb-0 px-2">
        @for($h = $gantt->getStart(true); $h<$gantt->getEnd(true);$h+=$gridX)
            <div class="flex-fill">
                <small>{{ $h }}</small>
            </div>
        @endfor
    </div>
    <div class="d-block d-lg-none px-2">
        @foreach($gantt->getData() as $schedule)
            <div>
                @component('models.campus.schedule-item')
                    @slot('schedule', $schedule)
                    @slot('today', $today)
                    @slot('day', $day)
                @endcomponent
            </div>
        @endforeach
    </div>
    <div class="d-none d-lg-block px-2" style="position: relative;">
        @foreach($gantt->getData() as $schedule)
            <div style="position: relative; z-index: 10; width: 100%;">
                @component('models.campus.schedule-item')
                    @slot('schedule', $schedule)
                    @slot('today', $today)
                    @slot('day', $day)
                    @slot('style', join(';', [
                        "width:" . $gantt->durationToPercent($schedule->duration) . "%",
                        "margin-left:" . $gantt->getScheduleStart($schedule, true) . "%",
                    ]))
                @endcomponent
            </div>
        @endforeach
        <div class="d-flex px-2"
             style="position:absolute; width: 100%; height:100%; top:0; left:0; z-index: 0;">
            @for($col = 0, $h = $gantt->getStart(true); $h<$gantt->getEnd(true);$h+=$gridX,$col++)
                <span class="flex-fill @if($col) border-left @endif">
                </span>
            @endfor
        </div>
    </div>
</div>
