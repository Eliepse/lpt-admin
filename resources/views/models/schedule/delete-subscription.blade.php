@extends('dashboard-master')

<?php
use App\Schedule;
use App\Sets\DaysSet;

/**
 * @var Schedule $schedule
 */

$days = DaysSet::getKeys();
?>

@section('title', ucfirst($schedule->campus->name) . ": désinscription")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
                <form class="card"
                      action="{{ route('schedules.students.link', [$schedule, $student])  }}"
                      method="POST">

                    @csrf
                    @method("DELETE")

                    <div class="card-header">
                        <h3 class="card-title">Désinscrire un étudiant</h3>
                    </div>

                    <div class="card-body">
                        <p>
                            <strong>Classe</strong><br>
                            {{ $schedule->course->name }} ({{ $schedule->campus->name }})
                            <small>{{ $schedule->room }}</small>
                            à {{ $schedule->hour->format("H\hi") }}
                            <br>
                            <br>
                            <strong>Étudiant</strong><br>
                            {{ $student->getFullname() }}
                        </p>
                    </div>

                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-link ml-auto text-uppercase">Désinscrire</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
