@extends('dashboard-master')

<?php
use App\Campus;
use App\Sets\DaysSet;
use Illuminate\Database\Eloquent\Collection;

/**
 * @var Campus $campus
 * @var Collection $courses
 * @var App\Schedule $schedule
 */

$days = DaysSet::getKeys();
?>

@section('title', ucfirst($campus->name) . ": modification de classe ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
                <form class="card"
                      action="{{ route('schedules.update', $schedule)  }}"
                      method="POST">

                    @csrf
                    @method('put')

                    <div class="card-header">
                        <h3 class="card-title">Modifier une classe à {{ ucfirst($campus->name) }}</h3>
                    </div>

                    <div class="card-body">

                        <input type="hidden" name="campus" value="{{ $campus->id }}"/>

                        @component('components.form.select')
                            @slot('title', 'Cours')
                            @slot('name', 'course')
                            @slot('attrs', ['disabled' => true])
                            @slot('options', [["value" => "", "name" => $schedule->course->name . " ({$schedule->course->getDuration(true)})"]]);
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Salle de classe (optionel)')
                            @slot('name', 'room')
                            @slot('attrs', ['max' => 30])
                            @slot('type', 'string')
                            @slot('default', $schedule->room)
                        @endcomponent

                        @component('components.form.list')
                            @slot('title', 'Jour de cours')
                            @slot('name', 'day')
                            @slot('options', array_combine($days, $days));
                            @slot('default', $schedule->day)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Heure de début de la classe')
                            @slot('name', 'hour')
                            @slot('type', 'time')
                            @slot('attrs', ["step" => "60"])
                            @slot('default', $schedule->hour->format("H:i"))
                        @endcomponent

                        @component('components.form.date')
                            @slot('title', 'Période de cours')
                            @slot('name', ['start_at', 'end_at'])
                            @slot('required', true)
                            @slot('default', [
                                $schedule->start_at->toDateString(),
                                $schedule->end_at->toDateString()
                            ])
                        @endcomponent

                        @component('components.form.date')
                            @slot('title', 'Période d\'inscription')
                            @slot('name', ['signin_start_at', 'signin_end_at'])
                            @slot('required', false)
                            @slot('default', [
                                optional($schedule->signin_start_at)->toDateString(),
                                optional($schedule->signin_end_at)->toDateString()
                            ])
                        @endcomponent

                        @component('components.form.input-group')
                            @slot('title', 'Prix')
                            @slot('name', 'price')
                            @slot('type', 'number')
                            @slot('classes', 'text-right')
                            @slot('default', $schedule->price)
                            @slot('after')
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">€</span>
                                </div>
                            @endslot
                        @endcomponent

                        @component('components.form.input-group')
                            @slot('title', 'Effectif')
                            @slot('name', 'max_students')
                            @slot('type', 'number')
                            @slot('classes', 'text-right')
                            @slot('default', $schedule->max_students)
                            @slot('after')
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="fe fe-users"></i></span>
                                </div>
                            @endslot
                        @endcomponent

                        {{-- TODO(eliepse): add teachers --}}

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
