@extends('root')

@section('title', 'Connexion - ')

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

                    <div class="text-center mb-6">
                        <img src="{{ asset("images/logo-2.png") }}" class="h-6" alt="LPT Logo">
                    </div>

                    <form class="card" action="{{ route('login') }}" method="post">

                        @csrf

                        <div class="card-body p-6">
                            <div class="card-title">Connexion à LPT</div>

                            @component('components.form.input')
                                @slot('type', 'email')
                                @slot('name', 'email')
                                @slot('title', 'Adresse email')
                                @slot('placeholder', 'Votre adresse email')
                            @endcomponent

                            @component('components.form.input')
                                @slot('type', 'password')
                                @slot('name', 'password')
                                @slot('title', 'Mot de passe')
                                @slot('placeholder', 'Votre mot de passe')
                            @endcomponent

                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="remember"/>
                                    <span class="custom-control-label">Se rappeler de moi</span>
                                </label>
                            </div>

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            </div>
                        </div>

                    </form>

                    <div class="text-center text-muted">
                        {{--Already have account? <a href="./login.html">Sign in</a>--}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
