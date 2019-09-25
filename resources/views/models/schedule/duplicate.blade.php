@extends('dashboard-master')

<?php
use App\Schedule;
use App\Sets\DaysSet;

/**
 * @var Schedule $schedule
 */

$days = DaysSet::getKeys();
?>

@section('title', ucfirst($schedule->campus->name) . ": duplication de classe ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">

                <div class="mb-3">
                    <a href="{{ route('campuses.show', $schedule->campus) }}">
                        <i class="fe fe-arrow-left"></i> Page du campus</a>
                </div>

                <form class="card"
                      action="{{ route('schedules.duplicate', $schedule)  }}"
                      method="POST">

                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3 class="card-title">Dupliquer une classe à {{ ucfirst($schedule->campus->name) }}</h3>
                        <p>Permet de dupliquer une classe à un horaire différent.</p>
                    </div>

                    <div class="card-body bg-light">
                        <p>
                            <strong>Cours&nbsp;: </strong> {{ $schedule->course->name }} ({{ $schedule->course->getDuration(true) }})<br>
                            <strong>Prix&nbsp;: </strong> {{ $schedule->price }} €<br>
                            <strong>Salle&nbsp;: </strong> {{ $schedule->room ?? '/' }}<br>
                            <strong>Effectif&nbsp;: </strong> {{ $schedule->max_students }} élèves max<br>
                        </p>
                    </div>

                    <div class="card-body">

                        @component('components.form.list')
                            @slot('title', 'Jour de cours')
                            @slot('name', 'day')
                            @slot('options', array_combine($days, $days));
                            @slot('default', $schedule->day)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Heure de début de la classe')
                            @slot('name', 'hour')
                            @slot('type', 'time')
                            @slot('attrs', ["step" => "60"])
                            @slot('default', $schedule->hour->format("H:i"))
                        @endcomponent

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary ml-auto">Dupliquer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
