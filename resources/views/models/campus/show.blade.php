@extends('dashboard-master')

<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;use \Illuminate\Support\Str;
use App\Campus;
use App\Schedule;

/**
 * @var Campus $campus
 * @var Schedule $schedule
 * @var Collection $days
 * @var Collection $hours
 */

$today = \App\Enums\DaysEnum::getKey(Carbon::now()->dayOfWeek);

?>

@section('title', ucfirst($campus->name) . " - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-start">
            <div>
                <h1>{{ ucfirst($campus->name) }}</h1>
                <p>{{ $campus->postal_address }}</p>
            </div>
            <div>
                {{--<a class="btn btn-link" href="{{ route('campuses.edit', $campus) }}">
                    <i class="fe fe-edit-3"></i>
                    Modifier
                </a>--}}
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 border-bottom">
            <h4 class="mr-3">Classes</h4>
            <div class="d-flex flex-fill justify-content-between">
                <div>
                    @if(request('filter') === 'active' || empty(request('filter')))
                        <a href="?filter=active" class="btn btn-sm btn-secondary">En cours</a>
                    @else
                        <a href="?filter=active" class="btn btn-sm btn-outline-secondary">En cours</a>
                    @endif
                    @if(request('filter') === 'next')
                        <a href="?filter=next" class="btn btn-sm btn-secondary">À venir</a>
                    @else
                        <a href="?filter=next" class="btn btn-sm btn-outline-secondary">À venir</a>
                    @endif
                </div>
                <div>
                    @can('create', App\Schedule::class)
                        <a href="{{ route('schedules.create', ['campus' => $campus]) }}" class="btn btn-sm btn-link">
                            <i class="fe fe-calendar"></i> Ajouter un classe
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col">
                @foreach($days as $day => $hours)
                    <h5 class="mt-3">{{ Illuminate\Support\Str::ucfirst(__($day)) }}</h5>
                    <div class="card">
                        <div class="row no-gutters">

                            @for($h = $min->hour; $h <= $max->hour; $h++)
								<?php $schedules = $hours[ $h ] ?? []; ?>
                                <div class="day {{ empty($schedules) ? 'col' : 'col-2' }} {{--'day-active'--}}">
                                    <div class="day-header">{{ $h }}h</div>
                                    <div class="day-body">

                                        @foreach($schedules as $schedule)
                                            @component('models.campus.schedule-item')
                                                @slot('schedule', $schedule)
                                                @slot('today', $today)
                                                @slot('day', $day)
                                            @endcomponent
                                        @endforeach

                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                @endforeach
                {{--<div class="row no-gutters">
                    @foreach(\App\Sets\DaysSet::getKeys() as $day)
                        <div class="col day {{ $today === $day ? 'day-active' : '' }}">
                            <div class="day-header">{{ $day }}</div>
                            <div class="day-body">
                                @foreach($schedules[$day] ?? collect() as $schedule)

                                    @component('models.campus.schedule-item')
                                        @slot('schedule', $schedule)
                                        @slot('today', $today)
                                        @slot('day', $day)
                                    @endcomponent

                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>--}}
            </div>
        </div>

    </div>

@endsection
