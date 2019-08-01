<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
    <li class="nav-item">
        <form action="{{ route('search') }}">
            <div class="input-group input-group-sm mt-1">
                <input type="text" name="search" placeholder="Search" class="form-control" value="{{ request()->input('search', '') }}">
                <div class="input-group-append">
                    <input type="submit" class="btn btn-outline-secondary xs" type="button" value="Go">
                </div>
            </div>
        </form>
    </li>
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @if (auth()->user()->role_id == 1)
                    <a class="dropdown-item" href="{{ route('a.users') }}">
                        {{ __('Admin') }}
                    </a>
                @endif
                <a class="dropdown-item" href="{{ route('profile') }}">
                    {{ __('Profile') }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rss') }}">{{ __('RSS') }}</a>
    </li>
</ul>
