@extends('dashboard-master')

<?php
/**
 * @var \App\Grade|null $grade
 */
?>

@section('title', 'Ajouter un cours - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('grades.store') }}" method="POST">

            @csrf

            <div class="card-header">
                <h3 class="card-title">Ajouter un cours</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">Une classe est définie par un horaire, un ensemble de cours et des étudiants.</p>

                @component('components.form.input')
                    @slot('title', 'Nom de la classe')
                    @slot('description', "Ce nom sera visible par les parents lors de l'inscription.")
                    @slot('name', 'title')
                    @slot('type', 'text')
                    @slot('placeholder', 'Chinois intensif, cours de dessin, ...')
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description du cours')
                    @slot('name', 'description')
                    @slot('placeholder', '')
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Prix')
                    @slot('description', 'Peut-être ajusté au cas par cas, une fois l\'étudiant ajouté à la classe.')
                    @slot('name', 'price')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000'])
                    @slot('placeholder', 'Le prix en euros')
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Niveau')
                    @slot('name', 'level')
                    @slot('options', [
                        '<i class="fe fe-x"></i>' => "0",
                        '1' => "1",
                        '2' => "2",
                        '3' => "3",
                        '4' => "4",
                        '5' => "5",
                        '6' => "6",
                    ])
                    @slot('default', "")
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    {{--<a href="javascript:void(0)" class="btn btn-link">Retour</a>--}}
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>

        </form>
    </div>

@endsection