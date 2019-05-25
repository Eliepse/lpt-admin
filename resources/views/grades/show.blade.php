@extends('dashboard-master')

<?php
use App\Grade;
use App\Student;
use \Illuminate\Support\Str;
/**
 * @var Grade $grade
 * @var Student $student
 * @var \Illuminate\Database\Eloquent\Collection $new_students
 */
?>

@section('title', "Classe : {$grade->title} - ")

@section('main')

    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $grade->title }}</h3>
                {{--<div class="card-options"></div>--}}
            </div>
            <div class="card-body">
                <p><strong>Local :</strong> {{ Str::ucfirst($grade->location) }}</p>
                <p><strong>Prix :</strong> {{ Str::ucfirst($grade->price) }}</p>
                <p><strong>Responsable :</strong> {{ Str::ucfirst($grade->teacher->getFullname()) }}</p>
            </div>
            <div class="card-body">
                <p>
                    Chaque {{ Str::title(join(', ', $grade->timetable_days)) }}<br>
                    de {{ $grade->timetable_hour->format('H:i') }}
                    à {{ $grade->timetable_hour->copy()->addMinutes($grade->getDuration())->format('H:i') }}
                </p>
                <p>
                    Période de cours : {{ $grade->start_at->toDateString() . ' - ' . $grade->end_at->toDateString() }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Étudiants ({{ $grade->students->count() . "/" . $grade->max_students }})</h3>
                <div class="card-options">
                    <button type="button"
                            class="btn btn-outline-primary btn-sm ml-2"
                            data-toggle="modal" data-target="#students-modal">
                        <span class="fe fe-user-plus"></span> Ajouter
                    </button>
                </div>
            </div>
            <div class="card-table">
                <table class="table table-vcenter">
                    <tbody>
                    @forelse($grade->students as $student)
                        <tr class="col-12 col-lg-6">
                            <td>{{ $student->getFullname() }}</td>
                            <td class="text-right">
                                <form action="{{ route('grades.students.unlink', [$grade, $student]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <span class="fe fe-x"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Aucun enfant associé</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @component('components.modal')
        @slot('title', "Sélection d'un étudiant")
        @slot('label', 'students-modal')
        @slot('size', 'modal-lg')
        @if($grade->students->count() >= $grade->max_students)
            <div class="alert alert-icon alert-warning" role="alert">
                <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>
                La classe a déjà atteint son effectif maximum. Il vous est cependant possible de la surcharger.
                Utilisez ce pouvoir avec sagesse !
            </div>
        @endif
        <table class="table table-vcenter table-striped">
            <tbody>
            @foreach($new_students as $student)
                <tr>
                    <td>{{ $student->getFullname() }}</td>
                    <td class="text-right">
                        <form action="{{ route('grades.students.link', [$grade, $student]) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="submit" class="btn btn-primary" value="Ajouter">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endcomponent

@endsection