@extends('dashboard-master')

@section('title', "Ajout d'un étudiant - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">

            <form class="col-12 col-md-8 col-lg-6" action="{{ route('students.store', $family) }}" method="POST">

                @csrf

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Ajout d'un étudiant</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.input')
                            @slot('title', 'Prénom')
                            @slot('name', 'firstname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Nom')
                            @slot('name', 'lastname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Date de naissance')
                            @slot('type', 'date')
                            @slot('name', 'birthday')
                            @slot('required', true)
                        @endcomponent

                        @component('components.form.textarea-input')
                            @slot('title', 'Notes')
                            @slot('name', 'notes')
                            @slot('attrs', ['max' => 1000])
                        @endcomponent

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('families.show', $family) }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
