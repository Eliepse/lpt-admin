@extends('dashboard-master')

<?php
use App\Grade;
use App\Student;
use \Illuminate\Support\Str;
/**
 * @var Grade $grade
 * @var Student $student
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
                    {{--<a href="#" class="btn btn-outline-primary btn-sm ml-2"><span class="fe fe-user-plus"></span> Ajouter</a>--}}
                </div>
            </div>
            <div class="card-table">
                <table class="table table-vcenter">
                    <tbody>
                    @forelse($grade->students as $student)
                        <tr class="col-12 col-lg-6">
                            <td>{{ $student->getFullname() }}</td>
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

@endsection