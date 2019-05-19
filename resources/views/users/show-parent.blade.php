@extends('dashboard-master')

<?php
use App\User;
use App\Student;
/**
 * @var User $parent
 */
?>

@section('title', "{$parent->getFullname()} - ")

@section('main')

    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $parent->getFullname() }}</h3>
            </div>
            <div class="card-body">
                @isset($parent->wechat_id)
                    <h4>Wechat</h4>
                    <p>{{ $parent->wechat_id }}</p>
                @endisset

                <h4>Téléphone</h4>
                <p>{{ $parent->phone }}</p>

                <h4>Adresse</h4>
                <p>{{ $parent->address }}</p>
            </div>
            {{--            @if()--}}
        </div>
    </div>

    <div class="col-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Enfants</h3>
            </div>
            {{--<div class="card-body"></div>--}}
            <div class="card-table">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Âge</th>
                        <th>Classe</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($parent->children as $student)
                        <?php /** @var Student $student */ ?>
                        <tr>
                            <td>{{ $student->firstname }}</td>
                            <td>{{ $student->birthday->diffForHumans(null, null, true) }}</td>
                            <td>{{ '[todo]' }}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">
                                Aucun enfant associé
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection