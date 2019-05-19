<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg order-lg-first">

                @guest
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link"><i class="fe fe-log-in"></i> Connexion</a>
                        </li>
                    </ul>
                @endguest

                @auth
                    <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link"><i class="fe fe-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('grades.index') }}" class="nav-link"><i class="fe fe-calendar"></i> Classes</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('courses.index') }}" class="nav-link"><i class="fe fe-book"></i> Cours</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link"><i class="fe fe-users"></i> Équipe</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('parents.index') }}" class="nav-link"><i class="fe fe-users"></i> Parents</a>
                        </li>
                    </ul>
                @endauth

            </div>
        </div>
    </div>
</div>