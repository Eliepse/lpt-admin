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

                <div class="form-group">
                    <label class="form-label">Durée</label>
                    <div class="input-group">
                        <input type="number" class="form-control text-right" name="duration" min="1" max="65000"
                               placeholder="Durée en minutes" value="30">
                        <span class="input-group-append"><span class="input-group-text">min</span></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Enseignant.e</label>
                    <select class="form-control custom-select" name="teacher">
                        <?php
                        /**
                         * @var \App\User $teacher
                         */
                        $teachers = \App\User::teacher()->select(['id', 'firstname', 'lastname'])->get();
                        ?>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->lastname . ' ' . $teacher->firstname }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    <a href="javascript:void(0)" class="btn btn-link">Annuler</a>
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

    {{--<div class="col-3">--}}
    {{--<div class="card">--}}
    {{--<table class="table card-table">--}}
    {{--<tr>--}}
    {{--<td>Name</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
    {{--<td>Période</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
    {{--<td>Durée</td>--}}
    {{--</tr>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection