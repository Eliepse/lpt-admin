@extends('dashboard-master')

<?php
use App\Grade;
use App\Student;
use \Illuminate\Support\Str;
/**
 * @var Grade $grade
 * @var \App\Lesson $lesson
 * @var \Illuminate\Database\Eloquent\Collection $new_students
 */
?>

@section('title', "[Cours] {$grade->title} - ")

@section('main')

    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $grade->title }}</h3>
                <div class="card-options">
                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-outline-primary btn-sm ml-2">
                        <span class="fe fe-edit-2"></span> Modifier
                    </a>
                    {{--<a href="{{ route('grades.create', ["grade" => $grade]) }}" class="btn btn-outline-secondary btn-sm ml-2">--}}
                    {{--<span class="fe fe-plus"></span> Dupliquer--}}
                    {{--</a>--}}
                </div>
            </div>
            <div class="card-body">
                <p>{{ $grade->description }}</p>
                <p><strong>Local :</strong> {{ Str::ucfirst($grade->location) }}</p>
                <p><strong>Prix :</strong> {{ Str::ucfirst($grade->price) }}</p>
                <p><strong>Responsable :</strong> {{ Str::ucfirst(optional($grade->teacher)->getFullname() ?? '/') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Leçons ({{ $grade->getDurationString() }})</h3>
                <div class="card-options">
                    <div class="card-options">
                        <a href="{{ route('grades.lessons.select', $grade) }}" class="btn btn-outline-primary btn-sm ml-2">
                            <span class="fe fe-plus"></span> Ajouter une leçon
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-table">
                <table class="table table-vcenter">
                    <tbody>
                    @forelse($grade->lessons as $lesson)
                        <tr class="col-12 col-lg-6">
                            <td>
                                {{ $lesson->name }}<br>
                                <p class="text-muted">{{ $lesson->description }}</p>
                            </td>
                            <td>{{ $lesson->pivot->getDurationString() }}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Aucune leçon associée</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-10">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Classes</h2>
                <div class="card-options">
                    <a href="{{ route('grades.classrooms.create', $grade) }}" class="btn btn-outline-primary btn-sm ml-2">
                        <span class="fe fe-plus"></span> Créer une classe
                    </a>
                </div>
            </div>
            <div class="card-table">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Horaires</th>
                        <th>Période de cours</th>
                        <th>Effectif</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($grade->classrooms as $classroom)
                        <tr>
                            <td>
                                @foreach($classroom->timetables as $day => $hours)
                                    {{ \Illuminate\Support\Str::ucfirst(__($day)) }}&nbsp;: {{ join(', ', $hours) }}<br>
                                @endforeach
                            </td>
                            <td>
                                Du {{ $classroom->first_day->toDateString() }}
                                au {{ $classroom->last_day->toDateString() }}<br>
                                à {{ \Illuminate\Support\Str::ucfirst($classroom->location) }}
                            </td>
                            <td>
                                {{ $classroom->students->count() }} / {{ $classroom->max_students }}<br>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('classrooms.show', $classroom) }}" class="btn btn-secondary">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Aucune classe associée</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection