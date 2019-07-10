@extends('dashboard-master')

<?php
use \App\Enums\LessonCategoryEnum;
use \App\Enums\LocationEnum;
use \App\Sets\DaysSet;
use \Illuminate\Support\Str;
?>


@section('title', 'LPT - ' . $classroom->name . ' (edition)')

@section('main')

    <classroom-form :id="{{ $classroom->id }}"></classroom-form>

@endsection