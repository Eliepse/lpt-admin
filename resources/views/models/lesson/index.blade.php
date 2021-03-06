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
                @can('create', App\Lesson::class)
                    <a class="btn btn-sm btn-link" href="{{ route('lessons.create') }}">
                        <i data-feather="plus"></i> Ajouter une leçon
                    </a>
                @endcan
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
                                @can('update', $lesson)
                                    <a class="btn btn-outline-secondary"
                                       href="{{ route('lessons.edit', $lesson) }}"><i data-feather="edit-2"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
