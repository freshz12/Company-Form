<nav class="navbar navbar-expand-lg navbar-light bg-light shadow mb-1 rounded">
    <div class="container">
        <a class="navbar-brand" href="{{ !Auth::user() ? '#' : url('home') }}"><img src="image/logo.png"
                style="width: 100px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- @canany(['Parameter Header View', 'Parameter Mapping View', 'Parameter Detail View'])
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('master') ? 'active' : ' ' }}" href="/">My Form</a>
                </li>
                @endcan --}}
            </ul>

            @if (Auth::user())
                <div class="" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ $username ?? 'Guest' }}
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href={{ url('/logout') }}>Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif


        </div>
</nav>
