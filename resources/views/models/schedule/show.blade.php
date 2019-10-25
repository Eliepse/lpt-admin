@extends('dashboard-master')

<?php
use App\Course;
use App\Student;
use Illuminate\Support\Facades\Auth;

/**
 * @var \App\Schedule $schedule
 * @var Course $course
 * @var Student $student
 */
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->campus->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-start">
            <div>
                <h1>
                    {{ $schedule->course->name }}
                    <small class="text-muted">{{ $schedule->room }}</small>
                </h1>
                <p class="text-muted">
                    @can('view', $schedule->campus)
                        <a href="{{ route('campuses.show', $schedule->campus) }}">
                            {{ \Illuminate\Support\Str::title($schedule->campus->name) }}
                        </a>
                    @elsecan
                        {{ \Illuminate\Support\Str::title($schedule->campus->name) }}
                    @endcan
                    &middot; le {{ __($schedule->day) }} à {{ $schedule->hour->format("H \h i") }}
                    &middot; {{ $schedule->course->getDuration(true) }}
                    &middot; {{ $schedule->price }} €
                    <br>
                    Du {{ $schedule->start_at->toDateString() }} au {{ $schedule->end_at->toDateString() }}
                </p>
                <p>
                </p>
            </div>
            <div>
                @can('create', App\Schedule::class)
                    <a class="btn btn-sm btn-link" href="{{ route('schedules.duplicate', $schedule) }}">
                        <i data-feather="copy"></i> Dupliquer</a>
                    <br>
                @endcan
                @can('update', $schedule)
                    <a class="btn btn-sm btn-link"
                       href="{{ route('schedules.edit', $schedule) }}"><i data-feather="edit"></i> Modifier</a>
                    <br>
                @endcan
                @can('delete', $schedule)
                    <a class="btn btn-sm btn-link" href="{{ route('schedules.delete', $schedule) }}">
                        <i data-feather="trash"></i> Supprimer</a>
                @endcan
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Étudiants</div>
                <div>
                    @can('subscribe', $schedule)
                        <a class="btn btn-sm btn-link"
                           href="{{ route('schedules.students.select', $schedule) }}">
                            <i data-feather="user-plus"></i> Ajouter un étudiant</a>
                    @endcan
                </div>
            </div>
            <div class="card-table">
                <table class="table table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted small border-bottom">
                        <th>Nom</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedule->students as $student)
						<?php $sub = $student->findSubscription($schedule); ?>
                        <tr>
                            <td>
                                @can('view', $student->family)
                                    <a href="{{ route('families.show', $student->family) }}">
                                        {{ $student->getFullname(true) }}
                                    </a>
                                @elsecan
                                    {{ $student->getFullname(true) }}
                                @endcan
                                <br>
                                <small class="text-muted">{{ $student->getAge() }} ans</small>
                            </td>
                            <td>
                                @if($sub->isOverPaid())
                                    <span class="text-info">+&nbsp;{{ $sub->paid - $sub->price }}&nbsp;€</span>
                                @elseif($sub->isPaid())
                                    <span class="text-muted">Payé</span>
                                @else
                                    <span class="text-danger">-&nbsp;{{ $sub->unpaidAmount() }}&nbsp;€</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @can('editSubscription', [$schedule, $student])
                                    <a href="{{ route('schedules.students.edit', [$schedule, $student]) }}"
                                       class="btn btn-sm btn-icon"><i data-feather="edit"></i></a>
                                @endcan
                                @can('unsubscribe', [$schedule, $student])
                                    <a href="{{ route('schedules.students.unlink', [$schedule, $student]) }}"
                                       class="btn btn-sm btn-icon"><i data-feather="trash"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="small text-muted">
                        <th></th>
                        <th>
                            {{ $schedule->getIncome() }}&nbsp;€ / {{ $schedule->subscriptions->isEmpty() ? $schedule->getTheoricalTotalIncome() : $schedule->getTotalIncome() }}&nbsp;€
                        </th>
                        <th>
                            <i data-feather="users"></i> {{ $schedule->students->count() }} / {{ $schedule->max_students }}
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

@endsection
