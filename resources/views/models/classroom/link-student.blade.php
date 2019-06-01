@extends('dashboard-master')

<?php
/**
 * @var \App\Lesson $lesson
 * @var \App\Grade $grade
 */
?>

@section('title', "Ajout d'un étudiant - ")

@section('main')

    <div class="col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4">
        <form class="card" action="{{ route('classrooms.students.link', [$classroom, $student]) }}" method="POST">

            @csrf
            @method('put')

            <div class="card-body">

                @component('components.form.input-group')
                    @slot('title', "Frais d'inscription")
                    @slot('name', 'price')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '-32500', 'max' => '32500'])
                    @slot('placeholder', "Le montant des frais d'inscription")
                    @slot('default', optional($student->subscription)->price ?? $grade->price)
                    @slot('required', true)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', "Montant payé")
                    @slot('name', 'paid')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '-32500', 'max' => '32500'])
                    @slot('placeholder', "Le montant déjà payé")
                    @slot('default', optional($student->subscription)->paid ?? 0)
                    @slot('required', true)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">€</span></span>
                    @endslot
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    <a href="{{ route('classrooms.show', $classroom) }}" class="btn btn-link">Retour</a>
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection