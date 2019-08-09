@extends('dashboard-master')

@section('main')

    <div class="container mt-3">
        <div class="row">

            @foreach($offices as $office)
                <div class="col col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ ucfirst($office->name) }}</div>
                        </div>
                        <div class="card-body">
                            {{ $office->schedules->count() }} horaires
                            {{-- TODO(eliepse): show a calendar visualization to see where are the active schedules --}}
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('offices.show', $office) }}" class="btn btn-primary">Ouvrir</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
