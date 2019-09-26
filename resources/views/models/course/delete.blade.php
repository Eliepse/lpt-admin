@extends('dashboard-master')

<?php
/**
 * @var App\Course $course
 */
?>

@section('title', " Suppression de cours ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-7 col-xl-6">

                <div class="mb-3">
                    <a href="{{ route('courses.show', $course) }}">
                        <i class="fe fe-arrow-left"></i> Page du cours</a>
                </div>

                <form class="card"
                      action="{{ route('courses.destroy', $course)  }}"
                      method="POST">

                    @csrf
                    @method("DELETE")

                    <div class="card-header">
                        <h3 class="card-title">Supprimer le cours {{ $course->name }}</h3>
                        <p>
                            Attention, vous êtes sur le point de supprimer un cours.<br>
                            Cette action est <strong>irréverssible.</strong>
                        </p>
                    </div>

                    <div class="card-body bg-light">
                        <p>
                            {{ $course->name }}<br>
                            {{ $course->description }}<br>
                            {{ $course->lessons()->count() }} leçons ({{ $course->getDuration(true) }})<br>
                            {{ $course->schedules()->count() }} classes associées<br>
                        </p>
                    </div>

                    <div class="card-footer text-right">
                        <div class="d-flex">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-link ml-auto text-uppercase">Supprimer le cours</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
