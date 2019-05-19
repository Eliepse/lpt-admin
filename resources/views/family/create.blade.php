@extends('dashboard-master')

<?php
use App\Family;
/**
 * @var Family $family
 */
?>

@section('title', 'Ajouter une famille - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card"
              action="{{ route('family.store')  }}"
              method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter une famille</h3>
            </div>

            <div class="card-body">
                <h4>Avertissement</h4>
                <p>
                    Attention, vous vous appréttez à créer une nouvelle famille. Si des membres ont déjà été
                    enregistrés, il est préférable d'ajouter directement des personnes à leur famille plutôt que de
                    risquer de créer des doublons.
                </p>
            </div>

            <div class="card-body">

                <h4>Parent responsable</h4>
                <p>
                    Ajouter un premier parent responsable, vous serez ensuite en mesure d'ajouter les autres membres
                    de la famille (parents, enfants).
                </p>

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
                    @slot('title', 'Email')
                    @slot('name', 'email')
                    @slot('type', 'email')
                @endcomponent

                @component('components.form.list')
                    @slot('title', 'Type de compte')
                    @slot('name', 'type')
                    @slot('options', [
                        'Parent' => 'parent',
                    ])
                    @slot('default', 'parent')
                    @slot('attrs', ['disabled'])
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Wechat ID')
                    @slot('name', 'wechat_id')
                    @slot('type', 'text')
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Téléphone')
                    @slot('name', 'phone')
                    @slot('type', 'phone')
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Adresse')
                    @slot('name', 'address')
                    @slot('type', 'text')
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