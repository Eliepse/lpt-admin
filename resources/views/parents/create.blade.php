@extends('dashboard-master')

<?php
use App\Family;
/**
 * @var Family $family
 */
?>

@section('title', 'Ajouter un parent - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card"
              action="{{ route('family.parent.store', $family)  }}"
              method="POST">

            {{ csrf_field() }}

            <div class="card-header">
                <h3 class="card-title">Ajouter un parent</h3>
            </div>

            <div class="card-body">

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
                        'Parent' => 'client',
                    ])
                    @slot('default', 'client')
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
                    {{--<a href="javascript:void(0)" class="btn btn-link">Annuler</a>--}}
                    <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>

@endsection