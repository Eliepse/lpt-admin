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
                <a class="btn btn-sm btn-link" href="{{ route('campuses.create') }}">
                    <i class="fe fe-plus"></i> Ajouter un campus
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-table">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted border-bottom">
                        <th>Nom</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campuses as $campus)
                        <tr>
                            <td>
                                {{ \Illuminate\Support\Str::title($campus->name) }}<br>
                                <small class="text-muted">{{ $campus->postal_address }}</small>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('campuses.show', $campus) }}"
                                   class="btn btn-sm btn-outline-secondary">Afficher</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
