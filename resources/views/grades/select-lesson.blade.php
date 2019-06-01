@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
/**
 * @var \Illuminate\Database\Eloquent\Collection $grades
 */
?>

@section('title', "[Cours] {$grade->title} - Ajouter une leçon - ")

@section('main')

    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Choisissez la leçon à ajouter</h2>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($lessons as $lesson)
                        <?php /** @var \App\Lesson $lesson */ ?>
                        <tr>
                            <td>
                                {{ $lesson->name }}<br>
                                <span class="text-muted">{{ $lesson->category }}</span>
                            </td>
                            <td>
                                <p>{{ $lesson->description }}</p>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('grades.lessons.link', [$grade, $lesson]) }}"
                                   class="btn btn-secondary">Ajouter</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas de leçon enregistrée.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection