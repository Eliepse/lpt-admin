@extends('dashboard-master')

<?php
use \App\Enums\LessonCategoryEnum;
use \App\Enums\LocationEnum;
use \App\Sets\DaysSet;
use \Illuminate\Support\Str;
?>


@section('title', 'LPT - ' . $course->name . ' (edition)')

@section('main')

    <course-form :id="{{ $course->id }}"></course-form>

@endsection
