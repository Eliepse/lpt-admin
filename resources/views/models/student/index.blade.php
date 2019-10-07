@extends('dashboard-master')

<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Str;
use App\Schedule;
use App\Family;
use App\ClientUser;
use App\User;
use App\Student;
use \App\Enums\DaysEnum;

/**
 * @var Schedule $schedule
 * @var Family $family
 * @var Collection $students
 * @var Student $student
 */

?>


@section('main')

    <div class="container justify-content-center mt-3">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Étudiants</h1>
            <div>
                @can('create', \App\Family::class)
                    <a class="btn btn-sm btn-link" href="{{ route('families.create') }}">
                        <i data-feather="plus"></i> Ajouter une famille
                    </a>
                @endcan
            </div>
        </div>

        <div class="row my-3 listjs-container">

            <div class="col-12 mb-2">
                <div class="input-group input-group-sm mb-1 ml-auto" style="max-width: 25rem;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i data-feather="search"></i></span>
                    </div>
                    <input type="text"
                           class="form-control bg-light listjs search"
                           placeholder="Chercher un étudiant, un parent, une famille..."
                           data-names="studentName,parentName">
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-table">
                        <table class="table table-hover table-borderless">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Parents</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <span class="studentName">{{ $student->getFullname(true) }}</span><br>
                                        <small class="text-muted">{{ $student->getAge() }} ans</small>
                                    </td>
                                    <td>
                                        <span class="parentName">{{ $student->parents
                                                ->map(function(\App\ClientUser $parent){
                                                    return $parent->getFullname(true);
                                                })->join(', ') }}</span>
                                    </td>
                                    <td class="text-right">
                                        @can('view', $student->family)
                                            <a href="{{ route('families.show', $student->family) }}"
                                               class="btn btn-sm btn-outline-secondary">Voir la famille</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
<script>
    import ListJsSearch from '../../../js/components/ListJsSearch'

    export default {
        components: {ListJsSearch}
    }
</script>
