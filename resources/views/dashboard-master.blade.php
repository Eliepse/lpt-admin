@extends('root')

@section('root-main')
    <div class="flex-fill">

        <div class="header py-4">
            <div class="container">
                <div class="d-flex">

                    <a class="header-brand" href="/">
                        <img src="{{ asset("images/logo-2.png") }}" class="header-brand-img" alt="LPT logo">
                    </a>

                    @auth
                        @include("navigation.user")
                    @endauth

                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>

                </div>
            </div>
        </div>

        @include("navigation.navigation")

        <div class="my-3 my-md-5">
            <div class="container">
                <div class="row justify-content-center">

                    @yield("main")

                </div>
            </div>
        </div>

    </div>
@endsection