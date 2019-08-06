@extends('dashboard-master')

<?php
use App\Schedule;
use App\Sets\DaysSet;

/**
 * @var Schedule $schedule
 */

?>

@section('title', ucfirst($schedule->office->name) . ": duplication d'horaire ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">

                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Classe enregistré !</h2>
                    </div>
                    <div class="card-body">
                        <p>Souhaitez-vous ajouter des horaires ?</p>
                        <p class="text-muted">
                            En cliquant sur <i>Oui</i>, vous pourrez créer une nouvelle
                            classe à partir de celle que vous venez de créer.
                        </p>
                    </div>

                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('office.show', $schedule->office) }}" class="btn btn-outline-secondary">Non</a>
                            <a href="{{ route('schedule.duplicate', $schedule) }}" class="btn btn-primary ml-auto">Oui</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
