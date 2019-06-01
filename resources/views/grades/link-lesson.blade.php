@extends('dashboard-master')

<?php
/**
 * @var \App\Lesson $lesson
 * @var \App\Grade $grade
 */
?>

@section('title', "[Cours] {$grade->title} - Ajout d'une lesson - ")

@section('main')

    <div class="col-12 col-sm-9 col-md-8 col-lg-5 col-xl-4">
        <form class="card" action="{{ route('grades.lessons.link', [$grade, $lesson]) }}" method="POST">

            @csrf
            @method('put')

            <div class="card-body">

                @component('components.form.input-group')
                    @slot('title', 'Durée de la leçon')
                    @slot('name', 'duration')
                    @slot('type', 'number')
                    @slot('classes', 'text-right')
                    @slot('attrs', ['min' => '1', 'max' => '65000'])
                    @slot('placeholder', 'La durée en minutes')
                    @slot('default', optional($lesson->pivot)->duration ?? 60)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">min</span></span>
                    @endslot
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    <a href="{{ route('grades.lessons.select', $grade) }}" class="btn btn-link">Retour</a>
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection