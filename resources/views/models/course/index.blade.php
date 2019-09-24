@extends('dashboard-master')

<?php
use App\Course;
use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Str;

/**
 * @var Collection $courses
 * @var Course $course
 */
?>

@section('title', "Cours - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Cours</h1>
            <div>
                <a class="btn btn-sm btn-link" href="{{ route('courses.create') }}">
                    <i class="fe fe-plus"></i> Ajouter un cours
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-table">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted border-bottom">
                        <th>Nom</th>
                        <th>Durée</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->getDuration(true) }}</td>
                            <td class="text-right">
                                <a href="{{ route('schedules.create', ['course' => $course]) }}"
                                   class="btn btn-sm btn-link">
                                    <i class="fe fe-calendar"></i> Nouvelle classe</a>
                                <a href="{{ route('courses.show', $course) }}"
                                   class="btn btn-sm btn-outline-secondary">Ouvrir</a>
                                <a href="{{ route('courses.edit', $course) }}"
                                   class="btn btn-sm btn-outline-secondary">Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
