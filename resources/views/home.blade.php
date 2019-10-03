@extends('dashboard-master')

<?php
/**
 * @var App\Campus $campus
 */
?>

@section('main')

    <div class="container mt-3">
        <div class="row">

            @foreach($campuses as $campus)
                <div class="col col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="card-title">
                                {{ ucfirst($campus->name) }}<br>
                                <small>{!! $campus->postal_address ?? '&nbsp;' !!}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $campus->schedules->count() }} classes
                        </div>
                        <div class="card-table">
                            @include('components.heatCalendar', ['stats' => $stats])
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('campuses.show', $campus) }}" class="btn btn-outline-primary">Afficher</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
