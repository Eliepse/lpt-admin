<?php

use App\Schedule;


/**
 * @var \App\Schedule $schedule
 * @var string $today
 * @var string $day
 */


/**
 * @param Schedule $schedule
 * @return string
 */
if (!function_exists('scheduleClass')) {
	function scheduleClass(Schedule $schedule): string
	{
// popSchedule-bgEnded

		if ($schedule->isStudyPeriod())
			return 'popSchedule-bgCurrent';

		if ($schedule->isSignupPeriod())
			return 'popSchedule-bgSoon';

		return '';
	}
}

$today = $today ?? null;
$day = $day ?? null;
?>

@can('view', $schedule)
    <a href="{{ route("schedules.show", $schedule) }}" class="schedule-link">
        @endcan

        <div style="{{ $style ?? '' }}"
             class="schedule {{ scheduleClass($schedule) }}
             @if($today === $day && $schedule->isClassNow()) schedule-active @endif">

            <div class="schedule-body">
                <div class="schedule-studentCount">
                    @if($schedule->isSignupPeriod())
                        {{ $schedule->subscriptions_count }}/{{ $schedule->max_students }}
                    @else
                        {{ $schedule->subscriptions_count }}
                    @endif
                    <i data-feather="users"></i>
                </div>
                <div class="">
                    {{ $schedule->hour->format("H:i") }} - {{ $schedule->hour->clone()->addMinutes($schedule->duration)->format("H:i") }}
                </div>
                <div class="schedule-location">{{ $schedule->course->name }}
                    <small>{{ $schedule->room }}</small>
                </div>
            </div>

            {{--                <div class="schedule-footer text-center">--}}

            {{--                    @if($schedule->isClassNow())--}}
            {{--                        <div><i data-feather="book-open"></i> Classe en cours</div>--}}
            {{--                    @elseif($schedule->isStudyPeriod() && $today === $day && $schedule->hour->isFuture())--}}
            {{--                        <div>--}}
            {{--                            <i data-feather="book"></i>--}}
            {{--                            Classe dans {{ $schedule->hour->diffInHours(\Carbon\Carbon::now()) }} h--}}
            {{--                        </div>--}}
            {{--                    @elseif($schedule->isStudyPeriod())--}}
            {{--                        <div><i data-feather="book"></i> Classe active</div>--}}
            {{--                    @elseif($schedule->isSignupPeriod())--}}
            {{--                        <div><i data-feather="user-plus"></i> Inscription</div>--}}
            {{--                    @else--}}
            {{--                        <div><i data-feather="archive"></i> Classe terminée</div>--}}
            {{--                    @endif--}}

            {{--                </div>--}}

        </div>
        @can('view', $schedule)
    </a>
@endcan
