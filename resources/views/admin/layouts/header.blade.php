<!-- Navbar Start -->
<nav class="navbar navbar-expand navbar-light sticky-top px-4 py-0 top-bar-nav mb-4">
    <div class="navbar top-bar-nav-wrp bg-light ">
        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
            <h3>Door Admin</h3>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <img src="{{ asset('img/toggle.svg') }}" />
        </a>
        @if (Route::is('dashboard'))
        <h5>Dashborard</h5>
        @elseif(Route::is('client.index'))
        <h5>Clients</h5>
        @elseif(Route::is('client.clients_prv'))
        <h5><span>Clients</span> <img src="{{ asset('img/arrow-right.svg') }}" /> Pierre Dupont</h5>
        @elseif(Route::is('projets.index'))
        <h5>Projets</h5>
        @elseif(Route::is('projets.projets_prv'))
        <h5><span>Projets</span> <img src="{{ asset('img/arrow-right.svg') }}"> ABCD SAS</h5>
        @elseif(Route::is('fournisseurs.index'))
        <h5>Fournisseurs</h5>
        @elseif(Route::is('financiers.index'))
        <h5>Financiers</h5>
        @elseif(Route::is('paramètres.index'))
        <h5>Paramètres</h5>
        @elseif(Route::is('statistiques.index'))
        <h5>Statistiques</h5>
        @elseif(Route::is('utilisateurs.index'))
        <h5>Utilisateurs</h5>
        @endif

        <div class="navbar-nav align-items-center ms-auto">

            <div class="nav-item dropdown drpdwn">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset('img/user.svg') }}" alt=""
                        style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    <!-- <a href="#" class="dropdown-item">Mon Profil</a>
                    <a href="#" class="dropdown-item">Paramètres</a> -->
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="success-message" id="success-message" style="display:none;"></div>
<div class="error-message" id="error-message" style="display:none;"></div>
<!-- Navbar End -->