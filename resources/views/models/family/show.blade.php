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

        <h1>Famille</h1>

        <div class="row mt-3">

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">Parents</div>
                    </div>
                    <div class="card-table">
                        <table class="table">
                            <tbody>
                            @foreach($family->parents as $parent)
                                <tr>
                                    <td>
                                        <strong class="text-capitalize">{{ $parent->getFullname(true) }}</strong><br>
                                        <span class="text-muted">{{ $parent->address }}</span>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $parent->phone }}">{{ $parent->phone }}</a><br>
                                        <a href="weixin://dl/chat?{{ $parent->wechat_id }}">{{ $parent->wechat_id }}</a><br>
                                        <a href="mailto:{{ $parent->email }}">{{ $parent->email }}</a>
                                    </td>
                                    <td class="text-right">
                                        {{-- TODO(eliepse): add action to parent --}}
                                        {{--<a href="javascript:void(0)" class="btn btn-link">test</a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">Enfants</div>
                        <div>
                            <a href="{{ route('student.create', $family) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fe fe-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="card-table">
                        <table class="table">
                            <tbody>
                            @foreach($family->students as $student)
                                <tr>
                                    <td>
                                        <strong class="text-capitalize">{{ $student->getFullname(true) }}</strong><br>
                                        <span class="text-muted">{{ $student->birthday->diffInYears() }} ans</span>
                                    </td>
                                    <td class="text-right">
                                        {{-- TODO(eliepse): add action to student --}}
                                        {{--<a href="javascript:void(0)" class="btn btn-link">test</a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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

        {{--                                        @component('models.office.schedule-item')--}}
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
