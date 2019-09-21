<?php
/** @var \App\User $user */
$user = auth()->user()
?>
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#"
           id="navbarUserDropdown"
           role="button"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <span class="d-none d-md-inline">{{ $user->getFullname() }}</span>
            <span class="d-md-none">{{ $user->getInitials() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUserDropdown">
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="dropdown-item">
                    <i class="dropdown-icon fe fe-log-out"></i> Déconnexion
                </button>
            </form>
        </div>
    </li>
</ul>
