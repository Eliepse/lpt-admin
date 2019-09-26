@extends('dashboard-master')

<?php
use App\Course;
use App\Student;
use \Illuminate\Support\Str;

/**
 * @var Course $course
 * @var Student $student
 */
?>

@section('title', "Cours: {$course->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-start">
            <div>
                <h1>
                    <small class="text-muted h6">
                        Cours
                        &middot; {{ $course->getDuration(true) }}
                        &middot; {{ $course->lessons->count() . ' ' . Str::plural('leçon', $course->lessons->count()) }}
                    </small>
                    <br>
                    {{ $course->name }}
                </h1>
                <p>
                    <small>{{ $course->description }}</small>
                </p>
            </div>
            <div>
                <a class="btn btn-link" href="{{ route('courses.edit', $course) }}">
                    <i class="fe fe-edit-3"></i> Modifier le cours
                </a><br>
                <a class="btn btn-link text-dark" href="{{ route('courses.delete', $course) }}">
                    <i class="fe fe-trash"></i> Supprimer le cours
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
                @foreach($course->lessons as $lesson)
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

        <div class="d-flex justify-content-between mt-5 border-bottom">
            <h4>Classes</h4>
            <div class="">
                <div class="">
                    <a href="{{ route('schedules.create', ['course' => $course]) }}" class="btn btn-sm btn-link">
                        <i class="fe fe-calendar"></i> Ajouter un classe
                    </a>
                </div>
            </div>
        </div>

        <schedule-calendar
            :schedules="{{ $course->schedules->toJson() }}"
            :course="{{ $course->toJson() }}">

        </schedule-calendar>
    </div>

@endsection
