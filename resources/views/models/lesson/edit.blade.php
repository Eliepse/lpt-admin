<?php
/**
 * @var App\Lesson $lesson
 */
?>use App\Lesson;
@extends('dashboard-master')

@section('title', "Modification d'une leçon - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('lessons.update', $lesson) }}" method="POST">

            @csrf
            @method('put')

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="mb-3">
                        @can('viewAny', \App\Lesson::class)
                            <a href="{{ route('lessons.index') }}">
                                <i class="fe fe-arrow-left"></i> Liste des leçons</a>
                        @endcan
                    </div>

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Modification d'une leçon</h3>
                            <p class="card-subtitle">
                                <i class="fe fe-alert-triangle text-warning"></i> Attention, cette modification sera effective
                                pour tous les cours passés et actuels dans lesquels cette leçon a été ajouté.<br>
                                Si la modification change le contenu, ou même le sens de cette leçon, il est préférable
                                de créer une nouvelle leçon.
                            </p>
                        </div>

                        <div class="card-body">

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'name')
                                @slot('required', true)
                                @slot('default', $lesson->name)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.textarea-input')
                                @slot('title', 'Description')
                                @slot('name', 'description')
                                @slot('default', $lesson->description)
                                @slot('attrs', ['max' => 250])
                            @endcomponent

                            @component('components.form.select')
                                @slot('title', 'Description')
                                @slot('name', 'category')
                                @slot('required', true)
                                @slot('default', $lesson->category)
                                @slot('options', collect(App\Enums\LessonCategoryEnum::getKeys())
                                    ->transform(function($el) {return ['name' => $el, 'value' => $el];}))
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
