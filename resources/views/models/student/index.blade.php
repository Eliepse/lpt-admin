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

$today = DaysEnum::getKey(Carbon::now()->dayOfWeek);

?>


@section('main')

    <div class="container justify-content-center mt-3">

        <h1 class="mt-3" style="margin-bottom: 3rem">Étudiants</h1>

        <div class="row my-3">
            <div class="col">
                <div class="card">
                    <div class="card-table">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Parents</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        {{ $student->getFullname(true) }}<br>
                                        <small class="text-muted">{{ $student->getAge() }} ans</small>
                                    </td>
                                    <td>
                                        {{
                                            $student->parents->map(
                                                function(\App\User $parent) {return $parent->getFullname(true); })
                                            ->join(', ')
                                        }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('family.show', $student->family) }}"
                                           class="btn btn-sm btn-outline-secondary">Famille</a>
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
