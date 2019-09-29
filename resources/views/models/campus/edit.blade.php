@extends('dashboard-master')
<?php
/**
 * @var App\Campus $campus
 */
?>
@section('title', "Modifier un campus - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('campuses.update', $campus) }}" method="POST">

            @csrf
            @method('put')

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="mb-3">
                        @can('view', $campus)
                            <a href="{{ route('campuses.show', $campus) }}">
                                <i class="fe fe-arrow-left"></i> Page du campus</a>
                        @endcan
                    </div>

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Modifier un campus</h3>
                            {{--<p class="card-subtitle"></p>--}}
                        </div>

                        <div class="card-body">

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'name')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                                @slot('default', $campus->name)
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Adresse postale (optionel)')
                                @slot('name', 'postal_address')
                                @slot('attrs', ['max' => 150])
                                @slot('default', $campus->postal_address)
                            @endcomponent

                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection
