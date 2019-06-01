@extends('dashboard-master')

<?php
/**
 * @var \App\Grade $grade
 */
?>

@section('title', 'Modifier une classe - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('grades.update', $grade) }}" method="POST">

            @csrf
            @method('put')

            <div class="card-header">
                <h3 class="card-title">Modifier une classe</h3>
            </div>

            <div class="card-body">

                @component('components.form.input')
                    @slot('title', 'Nom de la classe')
                    @slot('description', "Ce nom sera visible par les parents lors de l'inscription.")
                    @slot('name', 'title')
                    @slot('type', 'text')
                    @slot('placeholder', 'Chinois intensif, cours de dessin, ...')
                    @slot('default', $grade->title)
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description')
                    @slot('name', 'title')
                    @slot('default', $grade->description)
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Prix')
                    @slot('name', 'price')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000'])
                    @slot('placeholder', 'Le prix en euros')
                    @slot('default', $grade->price)
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
                    @slot('default', "{$grade->level}")
                @endcomponent

                <div class="card-footer text-right">
                    <div class="d-flex">
                        <a href="{{ route('grades.show', $grade) }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>
                </div>

        </form>
    </div>

@endsection