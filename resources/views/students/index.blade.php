@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
use \App\Student;
?>

@section('title', 'Comptes - ')

@section('main')

    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Étudiants</h2>
                <div class="card-options">
                    <a href="{{ route('parents.index') }}" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-book"></i> Parents</a>
                    {{--<a href="{{ route('grades.create') }}" class="btn btn-outline-primary btn-sm ml-2"><span class="fe fe-calendar"></span> Nouvelle classe</a>--}}
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Classes</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <?php /** @var Student $student */ ?>
                        <tr>
                            <td>
                                {{ $student->getFullname() }}<br>
                                <span class="text-muted">{{ $student->getAge() }} ans</span>
                            </td>
                            <td>
                                @foreach($student->getActiveGrades() as $grade)
                                    <?php /** @var \App\Grade $grade */ ?>
                                    {{ $grade->title }},
                                @endforeach
                            </td>
                            <td class="text-right">
                                <div class="btn-group" role="group" aria-label="Parent actions">
                                    @isset($student->family)
                                        <a href="{{ route('family.show', $student->family) }}" type="button" class="btn btn-secondary">Voir la famille</a>
                                    @endisset
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas d'étudiant enregistré</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection