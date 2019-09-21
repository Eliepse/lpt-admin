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

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->format("H \h i")} à {$schedule->office->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-start">
            <div>
                <h1>
                    {{ $schedule->course->name }}
                    <small class="text-muted">{{ $schedule->room }}</small>
                </h1>
                <p class="text-muted">
                    <a href="{{ route('offices.show', $schedule->office) }}">
                        {{ \Illuminate\Support\Str::title($schedule->office->name) }}</a>
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
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('schedules.duplicate', $schedule) }}">
                    <i class="fe fe-copy"></i> Dupliquer</a>
                <br>
                <a class="btn btn-sm btn-link"
                   href="{{ route('schedules.edit', $schedule) }}"><i class="fe fe-edit"></i> Modifier</a>
                <br>
                <a class="btn btn-sm btn-link" href="{{ route('schedules.delete', $schedule) }}">
                    <i class="fe fe-trash"></i> Supprimer</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Étudiants</div>
                <div>
                    <a class="btn btn-sm btn-outline-secondary"
                       href="{{ route('schedules.students.select', $schedule) }}">Ajouter</a>
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
                                <a href="{{ route('families.show', $student->family) }}">
                                    {{ $student->getFullname(true) }}
                                </a>
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
                                <a href="{{ route('schedules.students.edit', [$schedule, $student]) }}"
                                   class="btn btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                @if(Auth::guard('admin')->user()->isAdmin())
                                    <a href="{{ route('schedules.students.unlink', [$schedule, $student]) }}"
                                       class="btn btn-sm btn-icon"><i class="fe fe-trash"></i></a>
                                @endif
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
                            <i class="fe fe-users"></i> {{ $schedule->students->count() }} / {{ $schedule->max_students }}
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

@endsection
