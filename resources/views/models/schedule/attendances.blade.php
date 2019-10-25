@extends('dashboard-master')

<?php
use Illuminate\Database\Eloquent\Collection;

/**
 * @var \App\Schedule $schedule
 * @var \App\Student $student
 * @var \App\Attendance $attendance
 * @var Carbon\Carbon $referred_date
 * @var Collection $students
 * @var Collection $attendances
 */
?>

@section('title', "Classe du " . __($schedule->day) . " {$schedule->hour->toDateString()} à {$schedule->campus->name} - ")

@section('main')

    <div class="container mt-3">

        <div class="mb-3">
            <a href="{{ route('schedules.show', $schedule) }}">
                <i data-feather="arrow-left"></i> Page de la classe</a>
        </div>

        <div class="mb-3">
            <h3 class="card-title">Feuille de présence du {{ $referred_date->toDateString() }}</h3>
            <p>
                <small>{{ $schedule->course->name }} (@lang($schedule->day) {{ $schedule->hour->toDateString() }}
                    , {{ $schedule->campus->name }})</small>
            </p>
            <p class="text-muted">
                Cliquez sur les entrées pour modifier le status.
            </p>
        </div>

        @foreach($students as $student)
            <div class="row">
                <div class="col">
                    <div class="card-hover my-2 p-3 shadow rounded d-flex justify-content-between"
                         data-toggle="modal"
                         data-target="#modal-{{ $student->id }}">

                        <div>
                            <div class="h5 mb-0">{{ $student->getFullname(true) }}</div>
                            <small class="text-muted">{{ $student->getAge() }} ans</small>
                        </div>

                        <div class="d-flex px-3">
                            @if($attendance = $attendances->firstWhere('attendable_id', $student->id))
                                <div class="text-right align-self-center">
                                    @switch($attendance->state)
                                        @case(\App\Attendance::STATE_PRESENT)
                                        <div class="text-success">Présent</div>
                                        @break
                                        @case(\App\Attendance::STATE_LATE)
                                        <div class="text-warning">Présent (retard)</div>
                                        @break
                                        @case(\App\Attendance::STATE_ABSENT)
                                        <div class="text-danger">Absent</div>
                                        @break
                                    @endswitch
                                    @if($attendance->comment)
                                        <div class="small text-muted">{{ $attendance->comment }}</div>
                                    @endif
                                </div>
                            @else
                                <div class="text-right align-self-center">
                                    <div class="text-muted">En attente</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade"
                         id="modal-{{ $student->id }}"
                         tabindex="-1"
                         role="dialog"
                         aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form class="modal-content"
                                  action="{{ route('schedules.students.checkAttendances', [$schedule, $student]) }}"
                                  method="POST">
                                @csrf
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    <input type="hidden"
                                           name="referred_date"
                                           value="{{ $referred_date->toDateString() }}"
                                           readonly>

                                    @component('components.form.pills')
                                        @slot('title', 'Statut')
                                        @slot('name', 'state')
                                        @slot('options', ['Présent' => 'present','En retard' => 'late','Absent' => 'absent'])
                                        @slot('default', $attendance ? $attendance->state : 'present')
                                        @slot('required', true)
                                    @endcomponent

                                    @component('components.form.textarea-input')
                                        @slot('title', 'Commentaire')
                                        @slot('description', 'Indiquez la raison du retard ou de l\'abscence')
                                        @slot('name', 'comment')
                                        @slot('attrs', ['maxlength' => 250])
                                        @slot('default', $attendance ? $attendance->comment : null)
                                    @endcomponent
                                </div>
                                <div class="modal-footer d-block text-left">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection