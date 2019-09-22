@extends('root')

@section('root-main')

    @if(session()->has('alerts'))
        <div class="container mt-3">
            @foreach(session()->get('alerts') ?? [] as $alert)
                {!! $alert->render() !!}
            @endforeach
        </div>
    @endif

    @yield("main")
@endsection
