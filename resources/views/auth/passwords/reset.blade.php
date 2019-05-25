@extends('root')

@section('title', 'Réinitialiser le mot de passe - ')

<?php
/**
 * @var Illuminate\Support\MessageBag $errors
 * */
?>
@section('root-main')
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">

                    <form class="card" action="{{ route('password.update') }}" method="post">

                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="card-header">
                            <div class="card-title">Réinitialiser le mot de passe</div>
                        </div>

                        <div class="card-body p-6">

                            @component('components.form.input')
                                @slot('type', 'email')
                                @slot('name', 'email')
                                @slot('title', 'Adresse email')
                                @slot('placeholder', 'Votre adresse email')
                                @slot('default', $email ?? old('email'))
                                @slot('required', true)
                            @endcomponent

                            @component('components.form.input')
                                @slot('type', 'password')
                                @slot('name', 'password')
                                @slot('title', 'Nouveau mot de passe')
                                @slot('placeholder', '...')
                                @slot('required', true)
                            @endcomponent

                            @component('components.form.input')
                                @slot('type', 'password')
                                @slot('name', 'password_confirmation')
                                @slot('title', 'Confirmez le mot de passe')
                                @slot('placeholder', 'Renseignez à nouveau votre mot de passe')
                                @slot('required', true)
                            @endcomponent

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Envoyer le lien de réinitialisation</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection