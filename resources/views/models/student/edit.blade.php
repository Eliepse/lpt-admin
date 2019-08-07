<?php

use App\Student;

/**
 * @var Student $student
 */
?>

@extends('dashboard-master')

@section('title', "Modification d'un étudiant - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">

            <form class="col-12 col-md-8 col-lg-6" action="{{ route('student.update', $student) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Modification d'un étudiant</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.input')
                            @slot('title', 'Prénom')
                            @slot('name', 'firstname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                            @slot('default', $student->firstname)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Nom')
                            @slot('name', 'lastname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                            @slot('default', $student->lastname)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Date de naissance')
                            @slot('type', 'date')
                            @slot('name', 'birthday')
                            @slot('required', true)
                            @slot('default', $student->birthday->toDateString())
                        @endcomponent

                        @component('components.form.textarea-input')
                            @slot('title', 'Notes')
                            @slot('name', 'notes')
                            @slot('attrs', ['max' => 1000])
                            @slot('default', $student->notes)
                        @endcomponent

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('family.show', $student->family) }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection