<nav class="navbar navbar-expand-lg navbar-light sticky-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('landing_page') }}">RoadWatch</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto my-2 my-lg-0">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('landing_page') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing_page') }}#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('landing_page') }}#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('road_map.index') }}">Road Map</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roads.statistic') }}">Statistic</a>
                </li>
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    {{-- @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif --}}
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roads.index') }}">Roads Index</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roads.statistic') }}">Statistic</a>
                    </li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('road_map.index') }}">Roads Map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roads.report') }}">Waiting Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">User Management</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
