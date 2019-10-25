@guest
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link"><i data-feather="log-in"></i> Connexion</a>
        </li>
    </ul>
@endguest

@auth
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i data-feather="command"></i>
                <span class="d-none d-md-inline">Accueil</span>
            </a>
        </li>

        @can('viewAny', \App\Campus::class)
            <a href="{{ route('campuses.index') }}" class="nav-link">
                <i data-feather="home"></i> Campus
            </a>
        @endcan

        @can('viewAny', App\Student::class)
            <li class="nav-item">
                <a href="{{ route('students.index') }}" class="nav-link">
                    <i data-feather="github"></i>
                    <span class="d-none d-md-inline">Étudiants</span>
                </a>
            </li>
        @endcan

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void()" id="settingsDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="settings"></i>
                <span class="d-none d-md-inline">Paramètres</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('settings') }}" class="nav-link">
                        <i data-feather="grid"></i> Général
                    </a>
                @endif
                @can('viewAny', \App\Course::class)
                    <a href="{{ route('courses.index') }}" class="nav-link">
                        <i data-feather="book"></i> Cours
                    </a>
                @endcan
                @can('viewAny', \App\Lesson::class)
                    <a href="{{ route('lessons.index') }}" class="nav-link">
                        <i data-feather="layers"></i> Leçons
                    </a>
                @endcan
                @can('viewAny', \App\StaffUser::class)
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <i data-feather="users"></i> Équipe
                    </a>
                @endcan
            </div>
        </li>
    </ul>
@endauth
