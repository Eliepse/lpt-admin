@extends('dashboard-master')

<?php
/**
 * @var \App\User $parent
 */
?>

@section('title', 'Modifier un parent - ')

@section('main')

    <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">
        <form class="card"
              action="{{ route('parents.update', $parent)  }}"
              method="POST">

            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="card-header">
                <h3 class="card-title">Modifier un parent</h3>
            </div>

            <div class="card-body">

                @component('components.form.input')
                    @slot('title', 'Prénom')
                    @slot('name', 'firstname')
                    @slot('type', 'text')
                    @slot('default', $parent->firstname)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Nom')
                    @slot('name', 'lastname')
                    @slot('type', 'text')
                    @slot('default', $parent->lastname)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Email')
                    @slot('name', 'email')
                    @slot('type', 'email')
                    @slot('default', $parent->email)
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
                    @slot('default', $parent->wechat_id)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Téléphone')
                    @slot('name', 'phone')
                    @slot('type', 'phone')
                    @slot('default', $parent->phone)
                @endcomponent

                @component('components.form.input')
                    @slot('title', 'Adresse')
                    @slot('name', 'address')
                    @slot('type', 'text')
                    @slot('default', $parent->address)
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