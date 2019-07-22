@extends('dashboard-master')

<?php
use App\Classroom;
use App\Student;
use \Illuminate\Support\Str;

/**
 * @var Classroom $classroom
 * @var Student $student
 */
?>

@section('title', "Classe: {$classroom->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>
                <small class="text-muted h6">
                    Classe
                    &middot; {{ $classroom->getDuration(true) }}
                    &middot; {{ $classroom->lessons->count() . ' ' . Str::plural('leçon', $classroom->lessons->count()) }}
                </small>
                <br>
                {{ $classroom->name }}
            </h1>
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('classrooms.edit', $classroom) }}">
                    <i class="fe fe-edit-3"></i>
                    Modifier la classe
                </a>
            </div>
        </div>

        <div class="card">
            <table class="card-table table table-borderless table-striped table-vcenter">
                <thead>
                <tr class="text-uppercase text-muted border-bottom">
                    <th>
                        <small>Leçon</small>
                    </th>
                    <th>
                        <small>Durée</small>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($classroom->lessons as $lesson)
                    <tr>
                        <td>
                            <small class="text-uppercase text-muted text-gray">{{ $lesson->category }}</small>
                            <br>
                            {{ $lesson->name }}
                        </td>
                        <td>{{ $lesson->pivot->getDuration(true) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-5"><h4>Horaires</h4></div>

        <schedule-calendar
                :schedules="{{ $classroom->schedules->toJson() }}"
                :classroom="{{ $classroom->toJson() }}">

        </schedule-calendar>
    </div>

@endsection