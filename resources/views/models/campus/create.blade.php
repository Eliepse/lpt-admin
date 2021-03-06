@extends('dashboard-master')

@section('title', "Nouveau campus - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('campuses.store') }}" method="POST">

            @csrf

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="mb-3">
                        <a href="{{ route('campuses.index') }}"><i data-feather="arrow-left"></i> Liste des campus</a>
                    </div>

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Nouveau campus</h3>
                            {{--<p class="card-subtitle"></p>--}}
                        </div>

                        <div class="card-body">

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'name')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Adresse postale (optionel)')
                                @slot('name', 'postal_address')
                                @slot('attrs', ['max' => 150])
                            @endcomponent

                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection
