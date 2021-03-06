@extends('dashboard-master')

<?php
use App\Campus;
use App\Sets\DaysSet;
use Illuminate\Database\Eloquent\Collection;

/**
 * @var Campus $campus
 * @var Collection $courses
 */

$days = DaysSet::getKeys();
?>

@section('title', "Ajout de classe ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">

                <div class="mb-3">
                    @if($campuses->count() === 1)
                        <a href="{{ route('campuses.show', $campuses->first()) }}">
                            <i data-feather="arrow-left"></i> Page du campus</a>
                    @elseif($courses->count() === 1)
                        <a href="{{ route('courses.show', $courses->first()) }}">
                            <i data-feather="arrow-left"></i> Page du cours</a>
                    @else
                        <a href="{{ redirect()->back()->getTargetUrl() }}"><i data-feather="arrow-left"></i> Retour</a>
                    @endif
                </div>

                <form class="card"
                      action="{{ route('schedules.store')  }}"
                      method="POST">

                    {{ csrf_field() }}


                    <div class="card-header">
                        <h3 class="card-title">Ajouter une classe</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.select')
                            @slot('title', 'Cours')
                            @slot('name', 'course')
                            @slot('options', $courses->map(function (App\Course $course){
                                    return ["value" => $course->id, "name" => $course->name . " ({$course->getDuration(true)})"];
                                })->toArray());
                            @slot('readonly', $courses->count() === 1)
                        @endcomponent

                        @component('components.form.select')
                            @slot('title', 'Campus')
                            @slot('name', 'campus')
                            @slot('options', $campuses->map(function (App\Campus $campus){
                                    return ["value" => $campus->id, "name" => $campus->name];
                                })->toArray());
                            @slot('readonly', $campuses->count() === 1)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Salle de classe (optionel)')
                            @slot('name', 'room')
                            @slot('attrs', ['max' => 30])
                            @slot('type', 'string')
                        @endcomponent

                        @component('components.form.list')
                            @slot('title', 'Jour de cours')
                            @slot('name', 'day')
                            @slot('options', array_combine($days, $days));
                            @slot('default', 'monday')
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Heure de début de la classe')
                            @slot('name', 'hour')
                            @slot('type', 'time')
                            @slot('attrs', ["step" => "60"])
                            @slot('default', '10:00')
                        @endcomponent

                        @component('components.form.date')
                            @slot('title', 'Période de cours')
                            @slot('name', ['start_at', 'end_at'])
                            @slot('required', true)
                        @endcomponent

                        @component('components.form.date')
                            @slot('title', 'Période d\'inscription')
                            @slot('name', ['signin_start_at', 'signin_end_at'])
                            @slot('required', false)
                        @endcomponent

                        @component('components.form.input-group')
                            @slot('title', 'Prix')
                            @slot('name', 'price')
                            @slot('type', 'number')
                            @slot('classes', 'text-right')
                            @slot('default', 0)
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
                            @slot('default', 12)
                            @slot('after')
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i data-feather="users"></i></span>
                                </div>
                            @endslot
                        @endcomponent

                        {{-- TODO(eliepse): add teachers --}}

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
