@extends('dashboard-master')

<?php
use \App\Enums\LessonCategoryEnum;
?>

@section('title', 'Nouvelle leçon - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('lessons.store') }}" method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter une leçon</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Une <i>leçon</i> est une partie d'un cours complet (qui se compose donc de plusieurs leçons).
                    Lors
                    de l'ajout d'une leçon à un cours, vous serez amené à indiquer sa durée.
                </p>

                @component('components.form.input')
                    @slot('title', 'Nom de la leçon')
                    @slot('name', 'name')
                    @slot('type', 'text')
                    @slot('placeholder', '')
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description de la leçon')
                    @slot('name', 'description')
                    @slot('placeholder', '')
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Catégorie')
                    @slot('name', 'category')
                    @slot('options', array_combine(LessonCategoryEnum::getValues(), LessonCategoryEnum::getKeys()))
                    @slot('default', 'language')
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    {{--<a href="javascript:void(0)" class="btn btn-link">Annuler</a>--}}
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection