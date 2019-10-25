@extends('dashboard-master')

<?php
/**
 * @var App\StaffUser $staff
 */
?>

@section('title', "Changement du mot de passe d'un membre de l'équipe - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('staff.edit.password', $staff) }}" method="POST">

            @csrf
            @method('put')

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Modification d'un membre</h3>
                            {{--<p class="card-subtitle"></p>--}}
                        </div>

                        <div class="card-body">

                            @component('components.form.xray-password')
                                @slot('title', 'Mot de passe')
                                @slot('name', 'password')
                                @slot('required', true)
                                @slot('attrs', ['maxlength' => 64])
                            @endcomponent

                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('staff.index') }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection
