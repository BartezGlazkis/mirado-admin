<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle mr-3" href="#"><i class="fal fa-fw fa-bars"></i></a>
    <a class="navbar-brand" href="/">Mirado Admin Panel</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item dropdown">
                <a href="#" id="userDropdown" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fal fa-user-circle"></i> <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a href="#" class="dropdown-item">Профайл</a>
                    <a href="/logout" class="dropdown-item">Выйти</a>
                </div>
            </li>
            @endauth
        </ul>
    </div>
</nav>