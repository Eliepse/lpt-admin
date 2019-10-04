@extends('dashboard-master')

<?php
/**
 * @var App\Campus $campus
 */
?>

@section('main')

    <div class="container mt-3">

        @component('components.alert.default')
            @slot('class', 'info')
            @slot('message', 'Bientôt, votre page d\'accueil sera un espace avec des informations réellement utiles !')
        @endcomponent

        <div class="row">

            <div class="col-12 col-md-6, col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Cours de la journée
                    </div>
                    @if(!$todaySchedules->count())
                        <div class="card-body">
                            <p class="text-muted">Pas de classe aujourd'hui</p>
                        </div>
                    @else
                        <div class="card-table" style="overflow:auto; min-height:20rem; max-height:50vh;">
                            <table class="table table-borderless">
                                @foreach($todaySchedules as $campusSchedules)
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="text-muted text-uppercase bg-light">
                                            <small>
                                                {{ \Illuminate\Support\Str::ucfirst($campusSchedules->first()->campus->name) }}
                                                ({{ $campusSchedules->count() }} classes)
                                            </small>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($campusSchedules as $schedule)
                                        <tr>
                                            <td>
                                                {{ $schedule->course->name }}<br>
                                                <small>{{ $schedule->hour->hour }} h</small>
                                                @if($schedule->room)
                                                    <small>&middot; Salle {{ $schedule->room }}</small>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @can('view', $schedule)
                                                    <a href="{{ route('schedules.show', $schedule) }}"
                                                       class="btn btn-icon">
                                                        <i class="fe fe-eye"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
