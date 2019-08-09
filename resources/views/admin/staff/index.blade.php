@extends('dashboard-master')

<?php
use \Illuminate\Database\Eloquent\Collection;

/**
 * @var Collection $staff
 * @var \App\StaffUser $member
 */
?>

@section('title', "Équipe - ")

@section('main')

    <div class="container justify-content-center">

        <div class="d-flex mb-3 mt-3 justify-content-between align-items-end">
            <h1>Équipe</h1>
            <div>
                <a class="btn btn-outline-secondary" href="{{ route('staff.create') }}">
                    <i class="fe fe-plus"></i> Nouveau membre
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-table">
                <table class="table table-vcenter">
                    <thead>
                    <tr class="text-uppercase text-muted border-bottom">
                        <th>Nom</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($staff as $member)
                        <tr>
                            <td>
                                <strong>{{ $member->getFullname() }}</strong>
                                <br>
                                <a href="mailto:{{ $member->email }}">
                                    <small class="text-muted">{{ $member->email }}</small>
                                </a>
                                @if($member->wechat_id)
                                    <br>
                                    <a href="weixin://dl/chat?{{ $member->wechat_id }}">
                                        <small class="text-muted">{{ $member->wechat_id }}</small>
                                    </a>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::title($member->roles) }}</td>
                            <td class="text-right"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
