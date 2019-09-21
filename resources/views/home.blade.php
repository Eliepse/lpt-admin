@extends('dashboard-master')

<?php
/**
 * @var App\Office $office
 */
?>

@section('main')

    <div class="container mt-3">
        <div class="row">

            @foreach($offices as $office)
                <div class="col col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="card-title">
                                {{ ucfirst($office->name) }}<br>
                                <small>{{ $office->postal_address }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $office->schedules->count() }} classes
                            {{-- TODO(eliepse): show a calendar visualization to see where are the active schedules --}}
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('offices.show', $office) }}" class="btn btn-outline-primary">Afficher</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
