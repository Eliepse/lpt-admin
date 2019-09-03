@extends('dashboard-master')

<?php
use App\Lesson;
use \Illuminate\Database\Eloquent\Collection;

/**
 * @var Collection $lessons
 * @var Lesson $lesson
 */
?>

@section('title', "Leçons - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Leçons</h1>
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('lessons.create') }}">
                    <i class="fe fe-plus"></i> Nouvelle leçon
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-table">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted border-bottom">
                        <th>Nom</th>
                        <th>Categorie</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lessons as $lesson)
                        <tr>
                            <td>
                                {{ \Illuminate\Support\Str::title($lesson->name) }}<br>
                                <p class="text-muted">
                                    <small>{{ $lesson->description }}</small>
                                </p>
                            </td>
                            <td>{{ \Illuminate\Support\Str::title($lesson->category) }}</td>
                            <td class="text-right">
                                <a class="btn btn-outline-secondary"
                                   href="{{ route('lessons.edit', $lesson) }}"><i class="fe fe-edit-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
