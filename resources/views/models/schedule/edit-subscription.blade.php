@extends('dashboard-master')

<?php
use App\Sets\DaysSet;

/**
 * @var \App\Schedule $schedule
 * @var \App\Student $student
 * @var \App\Subscription $subscription
 */

$days = DaysSet::getKeys();
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->office->name} - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
                <form class="card"
                      action="{{ route('schedules.students.link', [$schedule, $student]) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h3 class="card-title">{{
                            "Classe du "
                             . __($schedule->day)
                            . " {$schedule->hour->format("H \h i")} à {$schedule->office->name}"
                        }}</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.input')
                            @slot('title', 'Prix')
                            @slot('name', 'price')
                            @slot('type', 'number')
                            @slot('default', $subscription->price)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Payé')
                            @slot('name', 'paid')
                            @slot('type', 'number')
                            @slot('default', $subscription->paid)
                        @endcomponent

                    </div>

                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-link">Annuler</a>
                            <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
