@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\User;
/**
 * @var Collection $users
 */
?>

@section('title', 'Équipe - ')

@section('main')

    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Comptes</h2>
                <div class="card-options">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm ml-2"><span class="fe fe-user-plus"></span> Ajouter un compte</a>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Dénomination</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <?php /** @var User $user */ ?>
                        <tr>
                            <td>
                                {{ $user->getFullname() }}&ensp;<span class="tag">{{ $user->type }}</span><br>
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <p class="text-center text-muted">Il n'y a pas de compte enregistré</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection