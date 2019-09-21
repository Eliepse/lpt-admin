@extends('dashboard-master')

<?php
/**
 * @var App\StaffUser $staff
 */
?>

@section('title', "Nouveau membre de l'équipe - ")

@section('main')
    <div class="container mt-3">

        <form action="{{ route('staff.update', $staff) }}" method="POST">

            @csrf
            @method('put')

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Modification d'un membre</h3>
                            {{--<p class="card-subtitle"></p>--}}
                        </div>

                        <div class="card-body">

                            @component('components.form.input')
                                @slot('title', 'Prénom')
                                @slot('name', 'firstname')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                                @slot('default', $staff->firstname)
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Nom')
                                @slot('name', 'lastname')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                                @slot('default', $staff->lastname)
                            @endcomponent

                            @if(Auth::guard('admin')->user()->isAdmin())
                                @component('components.form.list')
                                    @slot('title', 'Roles')
                                    @slot('name', 'roles[]')
                                    @slot('type', 'checkbox')
                                    @slot('options', array_combine(
                                        \App\Sets\UserRolesSet::getKeys(),
                                        \App\Sets\UserRolesSet::getKeys()))
                                    @slot('default', $staff->roles->getValues())
                                @endcomponent
                            @endif


                            @component('components.form.input')
                                @slot('title', 'Email')
                                @slot('name', 'email')
                                @slot('type', 'email')
                                @slot('required', true)
                                @slot('attrs', ['max' => 250])
                                @slot('default', $staff->email)
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Wechat ID')
                                @slot('name', 'wechat_id')
                                @slot('type', 'text')
                                @slot('required', true)
                                @slot('attrs', ['max' => 50])
                                @slot('default', $staff->wechat_id)
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Téléphone')
                                @slot('name', 'phone')
                                @slot('type', 'phone')
                                @slot('required', true)
                                @slot('attrs', ['max' => 16])
                                @slot('default', $staff->phone)
                            @endcomponent

                            @component('components.form.input')
                                @slot('title', 'Adresse postale (optionel)')
                                @slot('name', 'address')
                                @slot('type', 'text')
                                @slot('attrs', ['max' => 150])
                                @slot('default', $staff->address)
                            @endcomponent

                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('staff.index') }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ml-auto">Enregistrer</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
@endsection
