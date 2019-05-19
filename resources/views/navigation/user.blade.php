<?php
/** @var \App\User $user */
$user = auth()->user()
?>
<div class="d-flex order-lg-2 ml-auto">
    <div class="dropdown">

        <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
            <span class="avatar">{{ $user->getInitials() }}</span>
            <span class="ml-2 d-none d-lg-block">
              <span class="text-default">{{ $user->getFullname() }}</span>
              <small class="text-muted d-block mt-1">{{ $user->type }}</small>
            </span>
        </a>

        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="dropdown-item">
                    <i class="dropdown-icon fe fe-log-out"></i> Déconnexion
                </button>
            </form>
        </div>

    </div>
</div>