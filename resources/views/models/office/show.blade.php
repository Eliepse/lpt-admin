@extends('dashboard-master')

<?php
use App\Office;
use \Illuminate\Support\Str;

/**
 * @var Office $office
 */
?>

@section('title', "{$office->name} - ")

@section('main')

    <div class="container justify-content-center">
        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>{{ $office->name }}</h1>
            {{--            <div>--}}
            {{--                <a class="btn btn-outline-secondary" href="{{ route('classrooms.edit', $classroom) }}">--}}
            {{--                    <i class="fe fe-edit-3"></i>--}}
            {{--                    Modifier la classe--}}
            {{--                </a>--}}
            {{--            </div>--}}
        </div>

        <div class="d-flex justify-content-between mt-5">
            <h4>Horaires</h4>
{{--            <button class="btn btn-outline-secondary"><i class="fe fe-calendar"></i> Ajouter</button>--}}
        </div>

        <!--suppress HtmlUnknownTag -->
        <!--suppress CheckEmptyScriptTag -->
        {{-- TODO(eliepse): remove editable possibility? --}}
        <schedule-calendar :schedules="{{ $office->schedules->toJson() }}"/>

    </div>

@endsection