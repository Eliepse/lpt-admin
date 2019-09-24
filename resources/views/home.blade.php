@extends('dashboard-master')

<?php
/**
 * @var App\Office $office
 */
?>

@section('main')

    <div class="container mt-3">
        <div class="row">

            @foreach($offices as $office)
                <div class="col col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="card-title">
                                {{ ucfirst($office->name) }}<br>
                                <small>{!! $office->postal_address ?? '&nbsp;' !!}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $office->schedules->count() }} classes
                        </div>
                        <div class="card-table">
                            <table class="w-100" style="table-layout: fixed" border="0">
                                <thead>
                                <tr class="text-center" style="color: #4FD1C5">
                                    <th>
                                        <small>L</small>
                                    </th>
                                    <th>
                                        <small>M</small>
                                    </th>
                                    <th>
                                        <small>M</small>
                                    </th>
                                    <th>
                                        <small>J</small>
                                    </th>
                                    <th>
                                        <small>V</small>
                                    </th>
                                    <th>
                                        <small>S</small>
                                    </th>
                                    <th>
                                        <small>D</small>
                                    </th>
                                </tr>
                                </thead>
                                <tbody style="background-color: #F7FAFC">
                                @foreach($stats[$office->id] as $hour => $days)
                                    <tr>
                                        @foreach(App\Enums\DaysEnum::getKeys() as $day)
                                            @if(isset($days[$day]))
                                                @php
                                                    switch ($days[$day]) {
                                                    case 2: $bg = '#63B3ED'; break;
                                                    case 1: $bg = '#90CDF4'; break;
                                                    default: $bg = '#BEE3F8';
                                                    }
                                                @endphp
                                                <td style="height: .6rem; background-color: {{ $bg }}"></td>
                                            @else
                                                <td style="height: .6rem;"></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('offices.show', $office) }}" class="btn btn-outline-primary">Afficher</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
