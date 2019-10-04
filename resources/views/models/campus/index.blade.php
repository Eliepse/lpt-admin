@extends('dashboard-master')

<?php
use App\Campus;
use \Illuminate\Database\Eloquent\Collection;

/**
 * @var Collection $officies
 * @var Campus $campus
 */
?>

@section('title', "Campus - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Campus</h1>
            <div>
                @can('create', App\Campus::class)
                    <a class="btn btn-sm btn-link" href="{{ route('campuses.create') }}">
                        <i class="fe fe-plus"></i> Ajouter un campus
                    </a>
                @endcan
            </div>
        </div>

        <div class="container mt-3">
            <div class="row">

                @foreach($campuses as $campus)
                    <div class="col col-lg-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                {{ ucfirst($campus->name) }}<br>
                                <small class="text-muted">{!! $campus->postal_address ?? '&nbsp;' !!}</small>
                            </div>
                            <div class="card-body">
                                {{ $campus->schedules->count() }} classes
                            </div>
                            <div class="card-table">
                                @include('components.heatCalendar', ['stats' => $stats])
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                @can('view', $campus)
                                    <a href="{{ route('campuses.show', $campus) }}"
                                       class="btn btn-outline-primary">Afficher</a>
                                @endcan
                                @can('update', $campus)
                                    <a href="{{ route('campuses.edit', $campus) }}"
                                       class="btn btn-link">Modifier</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>

@endsection
