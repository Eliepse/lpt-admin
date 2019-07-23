@extends('dashboard-master')

<?php
use App\Office;
use App\Sets\DaysSet;
use Illuminate\Database\Eloquent\Collection;

/**
 * @var Office $office
 * @var Collection $classrooms
 */

$days = DaysSet::getKeys();
?>

@section('title', ucfirst($office->name) . ": ajout d'horaire ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
                <form class="card"
                      action="{{ route('schedule.store')  }}"
                      method="POST">

                    {{ csrf_field() }}


                    <div class="card-header">
                        <h3 class="card-title">Ajouter une classe à {{ ucfirst($office->name) }}</h3>
                    </div>

                    <div class="card-body">

                        <input type="hidden" name="office" value="{{ $office->id }}"/>

                        @component('components.form.select')
                            @slot('title', 'Cours')
                            @slot('name', 'classroom')
                            @slot('options', $classrooms->map(function ($classroom){
                                    return ["value" => $classroom->id, "name" => $classroom->name];
                                })->toArray());
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
                            @slot('default', 15)
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
                            <a href="{{ route('office.show', $office    ) }}" class="btn btn-link">Annuler</a>
                            <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection