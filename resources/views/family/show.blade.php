@extends('dashboard-master')

<?php
use App\User;
use App\Student;
use App\Family;
/**
 * @var Family $family
 * @var User $parent
 * @var Student $child
 */
?>

@section('title', "Famille - ")

@section('main')

    <div class="col-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Parents</h3>
                <div class="card-options">
                    <a href="{{ route('family.parent.create', $family) }}" class="btn btn-primary btn-sm ml-2"><span class="fe fe-user-plus"></span> Ajouter</a>
                </div>
            </div>
            <div class="card-body bg-gray-lightest">
                <div class="row row-deck">
                    @foreach($family->parents as $parent)
                        <div class="col-6">
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Enfants</h3>
                <div class="card-options">
                    <a href="{{ route('family.children.create', $family) }}" class="btn btn-primary btn-sm ml-2"><span class="fe fe-user-plus"></span> Ajouter</a>
                </div>
            </div>
            <div class="card-body bg-gray-lightest">
                <div class="row row-deck">
                    @forelse($family->children as $child)
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $child->firstname }}</h3>
                                </div>
                                <div class="card-body">
                                    <p>{{ $child->getAge() }} ans</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Aucun enfant associé</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection