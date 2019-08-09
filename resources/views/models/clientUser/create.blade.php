@extends('dashboard-master')

@section('title', "Ajout d'un parent - ")

@section('main')
    <div class="container mt-3">

        <div class="row justify-content-center">

            <form class="col-12 col-md-8 col-lg-6" action="{{ route('parents.store', $family) }}" method="POST">

                @csrf

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Ajout d'un parent</h3>
                    </div>

                    <div class="card-body">

                        @component('components.form.input')
                            @slot('title', 'Prénom')
                            @slot('name', 'firstname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Nom')
                            @slot('name', 'lastname')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Email')
                            @slot('name', 'email')
                            @slot('type', 'email')
                            @slot('required', true)
                            @slot('attrs', ['max' => 250])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Wechat ID')
                            @slot('name', 'wechat_id')
                            @slot('type', 'text')
                            @slot('required', true)
                            @slot('attrs', ['max' => 50])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Téléphone')
                            @slot('name', 'phone')
                            @slot('type', 'phone')
                            @slot('required', true)
                            @slot('attrs', ['max' => 16])
                        @endcomponent

                        @component('components.form.input')
                            @slot('title', 'Adresse postale')
                            @slot('name', 'address')
                            @slot('type', 'text')
                            @slot('required', true)
                            @slot('attrs', ['max' => 150])
                        @endcomponent

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('families.show', $family) }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
