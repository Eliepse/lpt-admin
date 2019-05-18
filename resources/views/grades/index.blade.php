@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
?>

@section('title', 'Classes - ')

@section('main')

    <div class="col-12">
        <div class="card">
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
                                {{ $grade->start_at->toDateString() }}<br>
                                {{ $grade->end_at->toDateString() }}
                            </td>
                            <td></td>
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