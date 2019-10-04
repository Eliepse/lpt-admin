@extends('dashboard-master')

<?php
/**
 * @var App\Campus $campus
 */
?>

@section('main')

    <div class="container mt-3">

        @component('components.alert.default')
            @slot('class', 'info')
            @slot('message', 'Bientôt, votre page d\'accueil sera un espace avec des informations réellement utiles !')
        @endcomponent

        <div class="row">


        </div>
    </div>

@endsection
