@extends('dashboard-master')

<?php
/**
 * @var \App\Lesson $lesson
 */
?>

@section('title', 'Modifier une leçon - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('lessons.update', $lesson) }}" method="POST">

            {{ csrf_field() }}
            {{ method_field('put') }}

            <div class="card-header">
                <h3 class="card-title">Modifier une leçon</h3>
            </div>

            <div class="card-body">

                @component('components.form.input')
                    @slot('title', 'Nom du leçon')
                    @slot('name', 'name')
                    @slot('type', 'text')
                    @slot('placeholder', '')
                    @slot('default', $lesson->name)
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description du leçon')
                    @slot('name', 'description')
                    @slot('placeholder', '')
                    @slot('default', $lesson->description)
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Catégorie')
                    @slot('name', 'category')
                    @slot('options', array_combine(LessonCategoryEnum::getKeys(), LessonCategoryEnum::getValues()))
                    @slot('default', $lesson->category)
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