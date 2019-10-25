@extends('dashboard-master')

<?php

use App\Subscription;use Carbon\Carbon;
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
        {{--<a href="#" class="btn btn-link"><i data-feather="arrow-left"></i> Retour</a>--}}

        <h1 class="mt-3" style="margin-bottom: 3rem">
            Famille
            <i>{{ $family->parents->pluck('lastname')->unique()->join('-') }}</i>
        </h1>

        <div class="my-3 d-flex justify-content-between">
            <h2 class="mb-0">Parents</h2>
            <div class="text-right">
                @can('create', $family)
                    <a href="{{ route('parents.create', $family) }}"
                       class="btn btn-sm btn-link">
                        <i data-feather="plus"></i> Ajouter un parent
                    </a>
                @endcan
            </div>
        </div>
        <hr>

        <div class="row my-3">
            @foreach($family->parents as $parent)
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title text-capitalize mb-0">
                                {{ $parent->getFullnameZh(true) }}
                                @if($parent->hasChineseNames())({{ $parent->getFullname(true) }})@endif
                            </div>
                            <div>
                                @can('update', $parent)
                                    <a href="{{ route('parents.edit', $parent) }}" class="btn btn-sm btn-icon">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ $parent->address }}</p>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li>
                                    <i data-feather="phone"></i>&nbsp;
                                    <a href="tel:{{ $parent->phone }}">{{ $parent->phone }}</a>
                                </li>
                                <li>
                                    <i data-feather="hash"></i>&nbsp;
                                    <a href="weixin://dl/chat?{{ $parent->wechat_id }}">{{ $parent->wechat_id }}</a>
                                </li>
                                <li>
                                    <i data-feather="mail"></i>&nbsp;
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
                @can('createChild', $family)
                    <a href="{{ route('students.create', $family) }}"
                       class="btn btn-sm btn-link">
                        <i data-feather="plus"></i> Ajouter un enfant
                    </a>
                @endcan
            </div>
        </div>
        <hr>

        <div class="row my-3">
            @foreach($family->students as $student)
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title mb-0">
                                <span class="text-capitalize">
                                    {{ $student->getFullnameZh(true) }}
                                    @if($student->hasChineseNames())({{ $student->getFullname(true) }})@endif
                                </span>
                            </div>
                            <div class="text-muted">
                                {{ $student->birthday->diffInYears() }} ans
                                @can('update', $student)
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-icon">
                                        <i data-feather="edit"></i></a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            @if($student->notes)<p class="font-italic">{{ $student->notes }}</p>@endif
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php /** @var Subscription $subscription */ ?>
                                @foreach($student->getActiveSubscriptions() as $subscription)
                                    <li>
                                        @can('view', $subscription->marketable)
                                            <a href="{{ route('schedules.show', $subscription->marketable) }}">
                                                {{ $subscription->marketable->course->name }}
                                                ({{ $subscription->marketable->day }}
                                                {{ $subscription->marketable->hour->format('H:i') }})
                                            </a>
                                        @elsecan
                                            {{ $subscription->marketable->course->name }}
                                            ({{ $subscription->marketable->day }}
                                            {{ $subscription->marketable->hour->format('H:i') }})
                                        @endcan
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

@endsection
