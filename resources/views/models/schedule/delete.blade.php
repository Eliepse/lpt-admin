@extends('dashboard-master')

<?php
use App\Schedule;
use App\Sets\DaysSet;

/**
 * @var Schedule $schedule
 */

$days = DaysSet::getKeys();
?>

@section('title', ucfirst($schedule->campus->name) . ": suppression de classe ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">

                <div class="mb-3">
                    <a href="{{ route('schedules.show', $schedule) }}">
                        <i class="fe fe-arrow-left"></i> Page de la classe</a>
                </div>

                <form class="card"
                      action="{{ route('schedules.trash', $schedule)  }}"
                      method="POST">

                    @csrf
                    @method("DELETE")

                    <div class="card-header">
                        <h3 class="card-title">Supprimer une classe</h3>
                        <p>
                            Attention, vous êtes sur le point de supprimer une classe.
                            Celle-ci sera placé dans une corbeille, elle existera toujours mais sera inactive.
                        </p>
                    </div>

                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('campuses.show', $schedule->campus) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-link ml-auto text-uppercase">Supprimer la classe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
