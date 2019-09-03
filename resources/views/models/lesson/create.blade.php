@extends('dashboard-master')

@section('title', "Nouvelle leçon - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('lessons.store') }}" method="POST">

            @csrf

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Nouvelle leçon</h3>
                            <p class="card-subtitle">
                                Une leçon est ce qui compose les cours. Elle peut-être utilisée pour composer plusieurs
                                cours. <br>
                                La durée d'une leçon est définie lors de l'ajout à un cours.
                            </p>
                        </div>

                        <div class="card-body">

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'name')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.textarea-input')
                                @slot('title', 'Description')
                                @slot('name', 'description')
                                @slot('required', true)
                                @slot('attrs', ['max' => 250])
                            @endcomponent

                            @component('components.form.select')
                                @slot('title', 'Description')
                                @slot('name', 'category')
                                @slot('required', true)
                                @slot('options', collect(App\Enums\LessonCategoryEnum::getKeys())
                                    ->transform(function($el) {return ['name' => $el, 'value' => $el];}))
                            @endcomponent

                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('lessons.index') }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection
