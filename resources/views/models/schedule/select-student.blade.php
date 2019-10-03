@extends('dashboard-master')

<?php
use App\Campus;
use App\Sets\DaysSet;
use Illuminate\Database\Eloquent\Collection;

/**
 * @var Campus $campus
 * @var \App\Schedule $schedule
 * @var \App\Student $student
 * @var Collection $courses
 * @var Collection $students
 */

$days = DaysSet::getKeys();
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->campus->name} - ")

@section('main')

    <div class="container mt-3">

        <div class="mb-3">
            <a href="{{ route('schedules.show', $schedule) }}">
                <i class="fe fe-arrow-left"></i> Page de la classe</a>
        </div>

        <div class="card listjs-container">

            <div class="card-header">
                <h3 class="card-title">Ajout d'un étduiant à une classe</h3>
                <div class="d-flex">
                    <div class="input-group input-group-sm ml-auto" style="max-width: 25rem;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fe fe-search"></i></span>
                        </div>
                        <input type="text"
                               class="form-control bg-light listjs search"
                               placeholder="Chercher un étudiant, un parent, une famille..."
                               data-names="studentName,parentName">
                    </div>
                </div>
            </div>

            <div class="card-table">
                <table class="table table-sm table-vcenter table-hover">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Parents</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @foreach($students as $student)
                        <tr>
                            <td>
                                <span class="studentName">{{ $student->getFullname(true) }}</span><br>
                                <small class="text-muted">{{ $student->getAge() }} ans</small>
                            </td>
                            <td>
                                        <span class="parentName">{{ $student->parents
                                                ->map(function(\App\ClientUser $parent){
                                                    return $parent->getFullname(true);
                                                })->join(', ') }}</span>
                            </td>
                            <td class="text-right">
                                <form action="{{ route('schedules.students.link', [$schedule, $student]) }}" method="POST">
                                    @csrf
                                    @method("PUT")
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Ajouter</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
