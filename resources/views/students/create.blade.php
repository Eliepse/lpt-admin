@extends('dashboard-master')

<?php
use App\Family;
use App\User;
/**
 * @var Family $family
 * @var User $parent
 */
?>

@section('title', 'Ajouter un étudiant - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card" action="{{ route('family.children.store', $family) }}" method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter un étudiant</h3>
            </div>

            <div class="card-body">

                <p class="text-muted">TODO</p>

                @component('components.form.input')
                    @slot('title', 'Prénom')
                    @slot('name', 'firstname')
                    @slot('type', 'text')
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Nom')
                    @slot('name', 'lastname')
                    @slot('type', 'text')
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Date de naissance')
                    @slot('name', 'birthday')
                    @slot('type', 'date')
                @endcomponent

                @component('components.form.textarea-input')
                    @slot('title', 'Notes')
                    @slot('name', 'notes')
                    @slot('placeholder', 'Indiquez toute information supplémentaire ici (allergie, relations, etc).')
                @endcomponent

            </div>

            <div class="card-footer text-right">
                <div class="d-flex">
                    <a href="javascript:void(0)" class="btn btn-link">Annuler</a>
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection