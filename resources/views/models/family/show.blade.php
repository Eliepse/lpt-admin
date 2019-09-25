@extends('dashboard-master')

<?php

use Carbon\Carbon;
use \Illuminate\Support\Str;
use App\Schedule;
use App\Family;
use App\ClientUser;
use App\Student;
use \App\Enums\DaysEnum;

/**
 * @var Schedule $schedule
 * @var Family $family
 * @var ClientUser $parent
 * @var Student $student
 */

$today = DaysEnum::getKey(Carbon::now()->dayOfWeek);

?>


@section('main')

    <div class="container justify-content-center mt-3">

        {{-- TODO(eliepse): Add link to index --}}
        {{--<a href="#" class="btn btn-link"><i class="fe fe-arrow-left"></i> Retour</a>--}}

        <h1 class="mt-3" style="margin-bottom: 3rem">Famille
            <i>{{ $family->parents->pluck('lastname')->unique()->join('-') }}</i></h1>

        <div class="my-3 d-flex justify-content-between">
            <h2 class="mb-0">Parents</h2>
            <div class="text-right">
                <a href="{{ route('parents.create', $family) }}"
                   class="btn btn-sm btn-link">
                    <i class="fe fe-plus"></i> Ajouter un parent
                </a>
            </div>
        </div>
        <hr>

        <div class="row my-3">
            @foreach($family->parents as $parent)
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title text-capitalize mb-0">{{ $parent->getFullname(true) }}</div>
                            <div>
                                <a href="{{ route('parents.edit', $parent) }}" class="btn btn-sm btn-icon">
                                    <i class="fe fe-edit"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ $parent->address }}</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li>
                                    <i class="fe fe-phone"></i>&nbsp;
                                    <a href="tel:{{ $parent->phone }}">{{ $parent->phone }}</a>
                                </li>
                                <li>
                                    <i class="fe fe-hash"></i>&nbsp;
                                    <a href="weixin://dl/chat?{{ $parent->wechat_id }}">{{ $parent->wechat_id }}</a>
                                </li>
                                <li>
                                    <i class="fe fe-mail"></i>&nbsp;
                                    <a href="mailto:{{ $parent->email }}">{{ $parent->email }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-3 d-flex justify-content-between" style="margin-top: 2rem;">
            <h2 class="mb-0">Étudiants</h2>
            <div class="text-right">
                <a href="{{ route('students.create', $family) }}"
                   class="btn btn-sm btn-link">
                    <i class="fe fe-plus"></i> Ajouter un enfant
                </a>
            </div>
        </div>
        <hr>

        <div class="row my-3">
            @foreach($family->students as $student)
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title mb-0">
                                <span class="text-capitalize">{{ $student->getFullname(true) }}</span>
                            </div>
                            <div class="text-muted">
                                {{ $student->birthday->diffInYears() }} ans
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-icon"><i class="fe fe-edit"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($student->notes)<p class="font-italic">{{ $student->notes }}</p>@endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- TODO(eliepse): add calendar visualization --}}
        {{--        <div class="row mt-3 mb-5">--}}
        {{--            <div class="col">--}}
        {{--                <div class="card">--}}
        {{--                    <div class="row no-gutters">--}}
        {{--                        @foreach(\App\Sets\DaysSet::getKeys() as $day)--}}
        {{--                            <div class="col day {{ $today === $day ? 'day-active' : '' }}">--}}
        {{--                                <div class="day-header">{{ $day }}</div>--}}
        {{--                                <div class="day-body">--}}
        {{--                                    @foreach($schedules[$day] ?? collect() as $schedule)--}}

        {{--                                        @component('models.campus.schedule-item')--}}
        {{--                                            @slot('schedule', $schedule)--}}
        {{--                                            @slot('today', $today)--}}
        {{--                                            @slot('day', $day)--}}
        {{--                                        @endcomponent--}}

        {{--                                    @endforeach--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        @endforeach--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </div>

@endsection
