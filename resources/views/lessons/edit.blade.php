@extends('dashboard-master')

<?php
/**
 * @var \App\Lesson $lesson
 */
?>

@section('title', 'Modifier un cours - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('lessons.update', $lesson) }}" method="POST">

            {{ csrf_field() }}
            {{ method_field('put') }}

            <div class="card-header">
                <h3 class="card-title">Modifier un cours</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">TODO</p>

                @component('components.form.input')
                    @slot('title', 'Nom du cours')
                    @slot('name', 'name')
                    @slot('type', 'text')
                    @slot('placeholder', '')
                    @slot('default', $lesson->name)
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description du cours')
                    @slot('name', 'description')
                    @slot('placeholder', '')
                    @slot('default', $lesson->description)
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Catégorie')
                    @slot('name', 'category')
                    @slot('options', [
                        'Langue' => 'language',
                        'Art' => 'art',
                        'Activité' => 'activity',
                    ])
                    @slot('default', $lesson->category)
                @endcomponent

                @component('components.form.input-group')
                    @slot('title', 'Durée')
                    @slot('name', 'duration')
                    @slot('type', 'number')
                    @slot('attrs', [
                        'min' => '1',
                        'max' => '65000',
                    ])
                    @slot('placeholder', 'Durée en minutes')
                    @slot('default', $lesson->duration)
                    @slot('after')
                        <span class="input-group-append"><span class="input-group-text">min</span></span>
                    @endslot
                @endcomponent

                <?php
                /** @var \Illuminate\Database\Eloquent\Collection $teachers */
                $teachers = \App\User::teacher()->select(['id', 'firstname', 'lastname'])->get();
                $options = $teachers->map(function (\App\User $teacher) {
                    return ['name' => $teacher->getFullname(), 'value' => $teacher->id,];
                });
                ?>
                @component('components.form.select')
                    @slot('title', 'Enseignant.e')
                    @slot('name', 'teacher')
                    @slot('options', $options)
                    @slot('default', $lesson->teacher_id)
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