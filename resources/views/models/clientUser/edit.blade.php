<?php

use App\ClientUser;

/**
 * @var  ClientUser $parent
 */

?>

@extends('dashboard-master')

@section('title', "Modification d'un parent - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">

            <form class="col-12 col-md-8 col-lg-6" action="{{ route('parents.update', $parent) }}" method="POST">

                @csrf
                @method('put')

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Modification d'un parent</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.input')
                            @slot('title', 'Prénom')
                            @slot('name', 'firstname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                            @slot('default', $parent->firstname)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Nom')
                            @slot('name', 'lastname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                            @slot('default', $parent->lastname)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Email')
                            @slot('name', 'email')
                            @slot('type', 'email')
                            @slot('required', true)
                            @slot('attrs', ['max' => 250])
                            @slot('default', $parent->email)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Wechat ID')
                            @slot('name', 'wechat_id')
                            @slot('type', 'text')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                            @slot('default', $parent->wechat_id)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Téléphone')
                            @slot('name', 'phone')
                            @slot('type', 'phone')
                            @slot('required', true)
                            @slot('attrs', ['max' => 16])
                            @slot('default', $parent->phone)
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Adresse postale')
                            @slot('name', 'address')
                            @slot('type', 'text')
                            @slot('required', true)
                            @slot('attrs', ['max' => 150])
                            @slot('default', $parent->address)
                        @endcomponent

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('families.show', $parent->family) }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
