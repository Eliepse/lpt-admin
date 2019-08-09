@guest
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link"><i class="fe fe-log-in"></i> Connexion</a>
        </li>
    </ul>
@endguest

@auth
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="fe fe-home"></i> Accueil</a>
        </li>
        {{--<li class="nav-item">--}}
        {{--<a href="{{ route('lessons.index') }}" class="nav-link"><i class="fe fe-book"></i> Cours</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
        {{--<a href="{{ route('users.index') }}" class="nav-link"><i class="fe fe-users"></i> Équipe</a>--}}
        {{--</li>--}}
        <li class="nav-item">
            <a href="{{ route('students.index') }}" class="nav-link"><i class="fe fe-github"></i> Étudiants</a>
        </li>
        @if(auth()->user()->isAdmin())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void()" id="settingsDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fe fe-settings"></i> Paramètres
                </a>
                <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                    <a href="{{ route('settings') }}" class="nav-link">
                        <i class="fe fe-grid"></i> Général
                    </a>
                    <a href="{{ route('classrooms.index') }}" class="nav-link">
                        <i class="fe fe-book"></i> Cours
                    </a>
                    <a href="{{ route('offices.index') }}" class="nav-link">
                        <i class="fe fe-home"></i> Bureaux
                    </a>
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <i class="fe fe-users"></i> Équipe
                    </a>
                </div>
            </li>
        @endif
    </ul>
@endauth

{{--</div>--}}
{{--</div>--}}
