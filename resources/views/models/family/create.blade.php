@extends('dashboard-master')

@section('title', "Nouvelle famille - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('family.store') }}" method="POST">

            @csrf

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Nouvelle famille</h3>
                    <p class="card-subtitle">
                        Utilisez ce formulaire seulement si la famille de l'étudiant n'a pas encore été créée.
                    </p>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h4>Parent</h4>

                            @component('components.form.input')
                                @slot('title', 'Prénom')
                                @slot('name', 'parent[firstname]')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'parent[lastname]')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Email')
                                @slot('name', 'parent[email]')
                                @slot('type', 'email')
                                @slot('required', true)
                                @slot('attrs', ['max' => 250])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Wechat ID')
                                @slot('name', 'parent[wechat_id]')
                                @slot('type', 'text')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Téléphone')
                                @slot('name', 'parent[phone]')
                                @slot('type', 'phone')
                                @slot('required', true)
                                @slot('attrs', ['max' => 16])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Adresse postale')
                                @slot('name', 'parent[address]')
                                @slot('type', 'text')
                                @slot('required', true)
                                @slot('attrs', ['max' => 250])
                            @endcomponent

                        </div>

                        <div class="col-12 col-md-6">
                            <h4>Étudiant</h4>

                            @component('components.form.input')
                                @slot('title', 'Prénom')
                                @slot('name', 'student[firstname]')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'student[lastname]')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Date de naissance')
                                @slot('type', 'date')
                                @slot('name', 'student[birthday]')
                                @slot('required', true)
                            @endcomponent

                            @component('components.form.textarea-input')
                                @slot('title', 'Notes')
                                @slot('name', 'student[notes]')
                                @slot('attrs', ['max' => 1000])
                            @endcomponent

                        </div>

                    </div>

                </div>

                <div class="card-footer text-right">
                    {{--                <a href="{{ route('family.index') }}" class="btn btn-link">Annuler</a>--}}
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>

            </div>

        </form>

    </div>
@endsection
