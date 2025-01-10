<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('home.page') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid" style="height: 40px; width: auto;">
        </a>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home.page ') ? 'active' : '' }}" href="{{ route('home.page') }}">@lang('lang.home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('friends.page') ? 'active' : '' }}" href="{{ route('friends.page') }}">@lang('lang.friend')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('market.avatar') ? 'active' : '' }}" href="{{ route('market.avatar') }}">@lang('lang.avatar')</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('chat*') ? 'active' : '' }}" href="{{ route('messages.chat') }}">@lang('lang.chat')</a>
                    </li>                
                @endauth
            </ul>
        </div>
        
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('friends.page') }}" class="d-flex me-2" role="search">
                <input class="form-control form-control-sm" type="text" name="name" placeholder="@lang('lang.search_friend')" aria-label="Search">
                <button class="btn btn-outline-light btn-sm" type="submit">@lang('lang.search')</button>
            </form>

            <div class="d-flex align-items-center me-2">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle btn-sm" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ app()->getLocale() == 'en' ? '🇺🇸 English' : '🇮🇩 Bahasa' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        @if(app()->getLocale() != 'en')
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">🇺🇸 English</a>
                            </li>
                        @endif
                        @if(app()->getLocale() != 'id')
                            <li>
                                <a class="dropdown-item" href="{{ route('locale.switch', 'id') }}">🇮🇩 Bahasa</a>
                            </li>
                        @endif
                    </ul>
                </div>

                @auth
                    <div class="mx-2">
                        <span class="text-light">Coins: <strong>{{ Auth::user()->coin }}</strong></span>
                    </div>

                    <div class="me-2">
                        <a href="{{ route('user.notifications') }}" class="text-light text-decoration-none">
                            <i class="bi bi-bell-fill" style="font-size: 1.5rem;"></i>
                        </a>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="text-light text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_picture ?: asset('assets/images/default-avatar.png') }}" alt="Profile" class="rounded-circle" style="height: 40px; width: 40px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="profileDropdown" style="width: 200px;">
                            <li>
                                <strong class="px-3 d-block text-truncate" style="max-width: 180px;">{{ Auth::user()->name }}</strong>
                            </li>
                            <li><a class="dropdown-item mt-2" href="{{ route('user.profile') }}">@lang('lang.profile')</a></li>
                            <li><a class="dropdown-item" href="{{ route('friends.requests') }}">@lang('lang.friend_request')</a></li>
                            <li><a class="dropdown-item" href="{{ route('wallet.topupPage') }}">@lang('lang.top_up') Coin</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">@lang('lang.logout')</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>

            @guest
                <div class="d-flex">
                    <a href="{{ route('auth.loginPage') }}" class="btn btn-primary btn-sm">@lang('lang.login')</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
