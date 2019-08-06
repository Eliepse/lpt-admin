@extends('dashboard-master')

<?php
use App\Classroom;
use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Str;

/**
 * @var Collection $classrooms
 * @var Classroom $classroom
 */
?>

@section('title', "Classes - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Cours</h1>
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('classroom.create') }}">
                    <i class="fe fe-plus"></i> Nouveau cours
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
                    @foreach($classrooms as $classroom)
                        <tr>
                            <td>{{ $classroom->name }}</td>
                            <td>{{ $classroom->getDuration(true) }}</td>
                            <td class="text-right">
                                <a href="{{ route('classrooms.show', $classroom) }}"
                                   class="btn btn-sm btn-outline-secondary">Ouvrir</a>
                                <a href="{{ route('classrooms.edit', $classroom) }}"
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
