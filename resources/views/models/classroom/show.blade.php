@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
/**
 * @var \App\Grade $grade
 * @var \App\Classroom $classroom
 * @var \App\Student $student
 */
?>

@section('title', "[Classroom] {$grade->title} - ")

@section('main')

    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Classe</h3>
                <div class="card-options">
                    <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-outline-primary btn-sm ml-2">
                        <span class="fe fe-edit-2"></span> Modifier
                    </a>
                </div>
            </div>
            <div class="card-body">
                <h4>Lieu</h4>
                <p>{{ $classroom->location }}</p>
                <h4>Horaires</h4>
                <ul>
                    @foreach($classroom->timetables as $day => $hours)
                        <li>{{ \Illuminate\Support\Str::ucfirst(__($day)) }}&nbsp;: {{ join(', ', $hours) }}</li>
                    @endforeach
                </ul>
                <h4>Période de cours</h4>
                <p>
                    Du <span class="text-info">{{ $classroom->first_day->toDateString() }}</span>
                    au <span class="text-info">{{ $classroom->last_day->toDateString() }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cours</h3>
            </div>
            <div class="card-body">
                <h4>Nom</h4>
                <p>{{ $grade->title }}</p>
                <h4>Durée</h4>
                <p>{{ $grade->getDurationString() }}</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-10">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Students ({{ $classroom->students->count() }}/{{ $classroom->max_students }})</h2>
                <div class="card-options">
                    <a href="{{ route('classrooms.students.select', $classroom) }}"
                       class="btn btn-outline-primary btn-sm ml-2">
                        <span class="fe fe-user-plus"></span> Ajouter une étudiant
                    </a>
                </div>
            </div>
            <div class="card-table">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classroom->students as $student)
                        <tr>
                            <td>{{ $student->getFullname() }}</td>
                            <td class="text-right">
                                <a href="{{ route('classrooms.students.link', [$classroom, $student]) }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fe fe-edit-2"></i>
                                </a>
                                <form method="post" class="d-inline"
                                      action="{{ route('classrooms.students.unlink', [$classroom, $student]) }}">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-outline-warning btn-sm"><i class="fe fe-x"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Aucun étudiant dans cette classe.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection