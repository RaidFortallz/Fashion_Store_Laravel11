<!-- Nav Bar -->
<nav class="navbar navbar-expand-lg bg-gradient-custom fixed-top py-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ '/' }}">Jawi<span>Que</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form action="{{ route('products.index') }}" method="GET" class="input-group mx-auto mt-5 mt-lg-0">
                <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="{{ request('q') }}"
                    aria-label="Cari..." aria-describedby="button-addon2">
                <button class="btn btn-outline-light" type="submit" id="button-addon2">
                    <i class='bx bx-search-big'></i>
                </button>
            </form>

            <ul class="navbar-nav ms-auto mt-3 mt-sm-0">
                <li class="nav-item me-3">
                    <a class="nav-link active" href="#">
                        <i class='bx bx-heart bx-rotate-90 bx-flip-horizontal'></i>
                    </a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link" href="{{ route('carts.index') }}">
                        <i class='bx bx-cart'></i>
                        <span class="badge text-bg-success rounded-circle position-absolute">1</span>
                    </a>
                </li>

                <!-- Buat HP -->
                <div class="dropdown mt-3 d-lg-none">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Menu
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ '/' }}">Home</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Produk</a></li>
                        <li><a class="dropdown-item" href="#">About</a></li>
                    </ul>
                </div>

                @guest
                    <li class="nav-item mt-5 mt-lg-0">
                        <a class="nav-link btn-login me-lg-3 text-center fw-bold" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                        <a class="nav-link btn-regis text-center fw-bold" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown mt-5 mt-lg-0">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-sm me-2">
                            @else
                                <img src="https://placehold.co/40x40/ff6f61/white?text={{ substr(Auth::user()->name, 0, 1) }}" alt="Avatar" class="avatar-sm me-2">
                            @endif
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#">Pesanan Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
