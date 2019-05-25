@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
?>

@section('title', 'Classes - ')

@section('main')

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Classes</h2>
                <div class="card-options">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-book"></i> Gérer les cours</a>
                    <a href="{{ route('grades.create') }}" class="btn btn-outline-primary btn-sm ml-2"><span class="fe fe-calendar"></span> Nouvelle classe</a>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Durée</th>
                        <th>Effectif</th>
                        <th>Période</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\Grade::all() as $grade)
                        <?php /** @var \App\Grade $grade */ ?>
                        <tr>
                            <td>
                                {{ $grade->title }}<br>
                                <span class="text-muted">{{ Str::ucfirst($grade->location) }}</span>
                            </td>
                            <td>
                                {{ Str::ucfirst($grade->timetable_days[0]) }}<br>
                                {{ $grade->timetable_hour->format('H:i') }} à
                                {{ $grade->timetable_hour->addMinutes($grade->courses()->sum('duration'))->format('H:i') }}
                                <br>
                            </td>
                            <td>
                                {{ $grade->students()->count() }} / {{ $grade->max_students }}
                                @isset($grade->teacher)
                                    <br>
                                    <span class="text-muted">{{ $grade->teacher->getFullname() }}</span>
                                @endisset
                            </td>
                            <td>
                                {{ $grade->first_day->toDateString() }} - {{ $grade->last_day->toDateString() }}<br>
                                @if($grade->booking_open_at)
                                    @if($grade->booking_open_at->isFuture())
                                        <span class="text-muted">
                                            Inscriptions {{ $grade->booking_open_at->diffForHumans() }}
                                        </span>
                                    @elseif($grade->booking_close_at->isFuture())
                                        <span class="text-success">
                                            Inscriptions en cours (fin {{ $grade->booking_close_at->diffForHumans() }})
                                        </span>
                                    @else
                                        <span class="text-muted">Inscriptions terminées</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-right">
                                @can('view', $grade)
                                    <a href="{{ route('grades.show', $grade) }}" type="button" class="btn btn-secondary">Voir</a>
                                @endcan
                                @can('update', $grade)
                                    <a href="{{ route('grades.edit', $grade) }}" type="button" class="btn btn-secondary">Modifier</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas de classe enregistrée</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection