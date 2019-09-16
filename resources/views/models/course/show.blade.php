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
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>
                <small class="text-muted h6">
                    Cours
                    &middot; {{ $course->getDuration(true) }}
                    &middot; {{ $course->lessons->count() . ' ' . Str::plural('leçon', $course->lessons->count()) }}
                </small>
                <br>
                {{ $course->name }}
            </h1>
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('courses.edit', $course) }}">
                    <i class="fe fe-edit-3"></i>
                    Modifier le cours
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

        <div class="d-flex justify-content-between mt-5"><h4>Classes</h4></div>

        <schedule-calendar
                :schedules="{{ $course->schedules->toJson() }}"
                :course="{{ $course->toJson() }}">

        </schedule-calendar>
    </div>

@endsection
