@extends('dashboard-master')

<?php
use App\Classroom;
use App\Student;

/**
 * @var \App\Schedule $schedule
 * @var Classroom $classroom
 * @var Student $student
 */
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->office->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>
                <small class="text-muted h6">
                    {{ \Illuminate\Support\Str::title($schedule->office->name) }}
                    &middot; le {{ __($schedule->day) }} à {{ $schedule->hour->format("H \h i") }}
                    &middot; {{ $schedule->classroom->getDuration(true) }}
                </small>
                <br>
                {{ $schedule->classroom->name }}
            </h1>
            {{--<div>
                <a class="btn btn-outline-secondary" href="{{ route('classrooms.edit', $classroom) }}">
                    <i class="fe fe-edit-3"></i>
                    Modifier la cours
                </a>
            </div>--}}
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Étudiants</div>
                <div>
                    <a class="btn btn-sm btn-outline-secondary"
                       href="{{ route('schedules.students.select', $schedule) }}">Ajouter</a>
                </div>
            </div>
            <div class="card-table">
                <table class="table table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted small border-bottom">
                        <th>Nom</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedule->students as $student)
                        <tr>
                            <td>
                                <a href="{{ route('families.show', $student->family) }}">
                                    {{ $student->getFullname(true) }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $student->getAge() }} ans</small>
                            </td>
                            <td>
                                @if($student->pivot->isOverPaid())
                                    <span class="text-info">+&nbsp;{{ $student->pivot->paid - $student->pivot->price }}&nbsp;€</span>
                                @elseif($student->pivot->isPaid())
                                    <span class="text-muted">Payé</span>
                                @else
                                    <span class="text-danger">-&nbsp;{{ $student->pivot->unpaidAmount() }}&nbsp;€</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('schedules.students.edit', [$schedule, $student]) }}"
                                   class="btn btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="small text-muted">
                        <th></th>
                        <th>
                            {{ $schedule->getActualPaidAmount() }}&nbsp;€ / {{ $schedule->getTheoricalPaidAmount() }}&nbsp;€
                        </th>
                        <th>
                            <i class="fe fe-users"></i> {{ $schedule->students->count() }} / {{ $schedule->max_students }}
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            {{--            <div class="card-footer">--}}
            {{--                <div class="text-right">--}}

            {{--                </div>--}}
            {{--            </div>--}}
        </div>

    </div>

@endsection
