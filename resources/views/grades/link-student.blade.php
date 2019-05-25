@extends('dashboard-master')

<?php
use App\Student;
/**
 * @var Student $student
 * @var \App\Grade $grade
 */
?>

@section('title', 'Classe : lier un étudiant - ')

@section('main')

    <div class="col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4">
        <form class="card" action="{{ route('grades.students.link', [$grade, $student]) }}" method="POST">

            @csrf
            @method('put')

            <div class="card-header">
                {{--<h3 class="card-title">Lier un étudiant à une classe</h3>--}}
            </div>

            <div class="card-body">

                {{--<p class="text-muted">TODO</p>--}}

                @component('components.form.input-group')
                    @slot('title', 'Frais d\'inscription')
                    @slot('name', 'price')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000'])
                    @slot('placeholder', 'Le prix en euros')
                    @slot('default', optional($student->subscription)->price ?? $grade->price)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Montant déjà encaissé')
                    @slot('name', 'paid')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000', 'step' => 1])
                    @slot('placeholder', 'Le montant en euros')
                    @slot('default', optional($student->subscription)->paid ?? 0)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    <a href="javascript:void(0)" class="btn btn-link">Annuler</a>
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informations</h3>
            </div>
            <div class="card-body">
                <h4>Classe</h4>
                <p>{{ $grade->title }}</p>
                <h4>Étudiant</h4>
                <p>{{ $student->getFullname() }}</p>
            </div>
        </div>
    </div>

@endsection