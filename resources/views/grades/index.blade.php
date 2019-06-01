@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
/**
 * @var \Illuminate\Database\Eloquent\Collection $grades
 */
?>

@section('title', 'Cours - ')

@section('main')

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Cours</h2>
                <div class="card-options">
                    <a href="{{ route('lessons.index') }}" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-book"></i> Gérer les leçons</a>
                    <a href="{{ route('grades.create') }}" class="btn btn-outline-primary btn-sm ml-2"><span class="fe fe-calendar"></span> Nouveau cours</a>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($grades as $grade)
                        <?php /** @var \App\Grade $grade */ ?>
                        <tr>
                            <td>
                                {{ $grade->title }}<br>
                                <span class="text-muted">{{ Str::ucfirst($grade->location) }}</span>
                            </td>
                            <td class="text-right">
                                @can('view', $grade)
                                    <a href="{{ route('grades.show', $grade) }}" type="button" class="btn btn-secondary">Voir</a>
                                @endcan
                                @can('update', $grade)
                                    <a href="{{ route('grades.edit', $grade) }}" type="button" class="btn btn-secondary">Modifier</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas encore de cours enregistré</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection