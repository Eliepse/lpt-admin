@extends('dashboard-master')

<?php
use App\Office;
use \Illuminate\Database\Eloquent\Collection;

/**
 * @var Collection $officies
 * @var Office $office
 */
?>

@section('title', "Campus - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Campus</h1>
            <div>
                <a class="btn btn-sm btn-link" href="{{ route('offices.create') }}">
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
                    @foreach($officies as $office)
                        <tr>
                            <td>
                                {{ \Illuminate\Support\Str::title($office->name) }}<br>
                                <small class="text-muted">{{ $office->postal_address }}</small>
                            </td>
                            <td class="text-right">
                                @can('view', $office)
                                    <a href="{{ route('offices.show', $office) }}"
                                       class="btn btn-sm btn-outline-secondary">Afficher</a>
                                @endcan
                                @can('update', $office)
                                    <a href="{{ route('offices.edit', $office) }}"
                                       class="btn btn-sm btn-outline-secondary">Modifier</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
