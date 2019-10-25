@extends('dashboard-master')

@section('title', "Ajout d'un étudiant - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">

            <form class="col-12 col-md-8 col-lg-6" action="{{ route('students.store', $family) }}" method="POST">

                @csrf

                <div class="mb-3">
                    <a href="{{ route('families.show', $family) }}">
                        <i data-feather="arrow-left"></i> Page de la famille</a>
                </div>

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Ajout d'un étudiant</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                @component('components.form.input')
                                    @slot('title', 'Prénom')
                                    @slot('name', 'firstname')
                                    @slot('required', true)
                                    @slot('attrs', ['max' => 50])
                                @endcomponent
                            </div>
                            <div class="col">
                                @component('components.form.input')
                                    @slot('title', 'Prénom chinois (optionel)')
                                    @slot('name', 'firstname_zh')
                                    @slot('required', false)
                                    @slot('attrs', ['max' => 50])
                                @endcomponent
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                @component('components.form.input')
                                    @slot('title', 'Nom')
                                    @slot('name', 'lastname')
                                    @slot('required', true)
                                    @slot('attrs', ['max' => 50])
                                @endcomponent
                            </div>
                            <div class="col">
                                @component('components.form.input')
                                    @slot('title', 'Nom chinois (optionel)')
                                    @slot('name', 'lastname_zh')
                                    @slot('required', false)
                                    @slot('attrs', ['max' => 50])
                                @endcomponent
                            </div>
                        </div>

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

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
