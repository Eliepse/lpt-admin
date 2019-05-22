@extends('dashboard-master')

@section('title', 'Ajouter un cours - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('courses.store') }}" method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter un cours</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">TODO</p>

                @component('components.form.input')
                    @slot('title', 'Nom du cours')
                    @slot('name', 'name')
                    @slot('type', 'text')
                    @slot('placeholder', '')
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Description du cours')
                    @slot('name', 'description')
                    @slot('placeholder', '')
                @endcomponent

                <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item bg-white">
                            <input type="radio" name="category" value="language" class="selectgroup-input" checked>
                            <span class="selectgroup-button">Langue</span>
                        </label>
                        <label class="selectgroup-item bg-white">
                            <input type="radio" name="category" value="art" class="selectgroup-input">
                            <span class="selectgroup-button">Art</span>
                        </label>
                        <label class="selectgroup-item bg-white">
                            <input type="radio" name="category" value="activity" class="selectgroup-input">
                            <span class="selectgroup-button">Activité</span>
                        </label>
                    </div>
                </div>

                @component('components.form.input-group')
                    @slot('title', 'Durée')
                    @slot('name', 'duration')
                    @slot('type', 'number')
                    @slot('attrs', [
                        'min' => '1',
                        'max' => '65000',
                    ])
                    @slot('placeholder', 'Durée en minutes')
                    @slot('default', 30)
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