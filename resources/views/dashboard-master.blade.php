@extends('root')
<?php
/**
 * @var Eliepse\Alert\Alert $alert
 */
?>
@section('root-main')

    @if(!session()->has('alerts'))
        <div class="container mt-3">
            @foreach(session()->get('alerts') ?? [] as $alert)
                @if(!$alert->isDissmissible())
                    {!! $alert->render() !!}
                @endif
            @endforeach
        </div>
        <div class="p-3" style="position: fixed; top: 3rem; right: 0; width: 100%; max-width: 30rem; z-index: 100;">
            @foreach(session()->get('alerts') ?? [] as $alert)
                @if($alert->isDissmissible)
                    {!! $alert->render() !!}
                @endif
            @endforeach
        </div>
    @endif

    @yield("main")

    <div style="height: 3.5rem;" role="none"></div>

@endsection
