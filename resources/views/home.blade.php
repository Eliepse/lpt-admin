@extends('dashboard-master')

<?php
/**
 * @var App\Campus $campus
 */
?>

@section('main')

    <div class="container mt-3">

        <div class="row">

            <!-- Stats: classes of the day -->
            <div class="col-12 col-sm-6 col-lg-4">
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
                                @foreach($todaySchedules->groupBy('campus_id') as $campusSchedules)
                                    <thead>
                                    <tr>
                                        <th colspan="2"
                                            class="text-muted text-uppercase"
                                            style="background-color: #EDF2F7;">
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
                                                <small class="text-muted">{{ $schedule->hour->hour }} h</small>
                                                @if($schedule->room)
                                                    <small class="text-muted">&middot; Salle {{ $schedule->room }}</small>
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

        @if(auth('admin')->user()->isAdmin())
            <!-- Stats: unpaid subscriptions -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            Inscriptions non payées<br>
                            <small>{{ $unpaidSubs->count() }} inscriptions non payées,</small>
                            <small>soit {{ $unpaidSubs->sum(function($s){return $s->unpaidAmount();}) }} € non payés</small>
                        </div>
                        @if(!$unpaidSubs->count())
                            <div class="card-body">
                                <p class="text-muted">Pas d'impayé. :)</p>
                            </div>
                        @else
                            <div class="card-table" style="overflow:auto; min-height:20rem; max-height:50vh;">
                                <table class="table table-borderless">
                                    <tbody>
                                    @foreach($unpaidSubs as $subscription)
                                        <tr>
                                            <td>
                                                {{ $subscription->student->getFullname(true) }}<br>
                                                <small class="text-muted">
                                                    {{ $subscription->marketable->course->name }}
                                                    à {{ $subscription->marketable->campus->name }}
                                                </small>
                                            </td>
                                            <td class="text-right">- {{ $subscription->unpaidAmount() }} €</td>
                                            <td class="text-right">
                                                @can('view', $subscription->marketable)
                                                    <a href="{{ route('schedules.show', $subscription->marketable) }}"
                                                       class="btn btn-icon">
                                                        <i class="fe fe-eye"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
        @endif

        <!-- Stats: general -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Statistiques générales
                    </div>
                    <div class="card-table">
                        <table class="table table-condensed table-borderless table-vcenter table-striped">
                            <tbody>
                            <tr>
                                <td>Étudiants</td>
                                <td>{{ \App\Student::count() }}</td>
                            </tr>
                            <tr>
                                <td>Inscriptions actives</td>
                                <td>{{ $subscriptions->count() }}</td>
                            </tr>
                            @if(auth('admin')->user()->isAdmin())
                                <tr>
                                    <td>s
                                        Chiffre d'affaire en cours<br>
                                        <small class="text-muted"><i>(not so relevent)</i></small>
                                    </td>
                                    <td>{{ $subscriptions->sum('paid') }} €</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Classes actives</td>
                                <td>{{ $activeSchedules->count() }}</td>
                            </tr>
                            <tr>
                                <td>Classes aujourd'hui</td>
                                <td>{{ $todaySchedules->count() }}</td>
                            </tr>
                            <tr>
                                <td>Heures de cours par semaine</td>
                                <td>
                                    {{ round($activeSchedules->sum('duration') / 60) }} h
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
