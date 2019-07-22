@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
use App\Office;
use App\Schedule;

/**
 * @var Office $office
 * @var Schedule $schedule
 */
?>

@section('title', "{$office->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>{{ $office->name }}</h1>
            {{--            <div>--}}
            {{--                <a class="btn btn-outline-secondary" href="{{ route('classrooms.edit', $classroom) }}">--}}
            {{--                    <i class="fe fe-edit-3"></i>--}}
            {{--                    Modifier la classe--}}
            {{--                </a>--}}
            {{--            </div>--}}
        </div>

        <div class="d-flex justify-content-between mt-5">
            <h4>Horaires</h4>
            {{--            <button class="btn btn-outline-secondary"><i class="fe fe-calendar"></i> Ajouter</button>--}}
        </div>

        <div class="row mt-3 mb-5">
            <div class="col">
                <div class="card">
                    <div class="row no-gutters">
                        @foreach(\App\Sets\DaysSet::getKeys() as $day)
                            <div class="col day">
                                <div class="day-header">{{ $day }}</div>
                                <div class="day-body">
                                    @foreach($schedules[$day] ?? [] as $schedule)
                                        <div class="schedule">
                                            <div class="schedule-studentCount">{{ $schedule->students_count }}
                                                <i class="fe fe-users"></i></div>
                                            <div class="schedule-hour">{{ $schedule->hour->format("H:i") }}</div>
                                            <div class="schedule-location">{{ $schedule->classroom->name }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection