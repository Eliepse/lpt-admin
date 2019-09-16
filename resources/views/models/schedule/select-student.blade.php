@extends('dashboard-master')

<?php
use App\Office;
use App\Sets\DaysSet;
use Illuminate\Database\Eloquent\Collection;

/**
 * @var Office $office
 * @var \App\Schedule $schedule
 * @var \App\Student $student
 * @var Collection $courses
 * @var Collection $students
 */

$days = DaysSet::getKeys();
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->office->name} - ")

@section('main')

    <div class="container mt-3">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Ajout d'un étduiant à une classe</h3>
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
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{ $student->getFullname(true) }}<br>
                                <small class="text-muted">{{ $student->getAge() }} ans</small>
                            </td>
                            <td>
                                {{
                                    $student->parents->map(
                                        function(\App\User $parent) {return $parent->getFullname(true); })
                                    ->join(', ')
                                }}
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
