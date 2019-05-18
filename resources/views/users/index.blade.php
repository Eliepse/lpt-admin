@extends('dashboard-master')

<?php
use \Illuminate\Support\Str;
?>

@section('title', 'Comptes - ')

@section('main')

    <div class="col-12">
        <div class="card">
            <div class="table-responsive">

                <table class="table table-outline table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Dénomination</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\User::all() as $user)
                        <?php /** @var \App\User $user */ ?>
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
                                <p class="text-center text-muted">Il n'y a pas de classe enregistrée</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection