<!-- Nav Bar -->
<nav class="navbar navbar-expand-lg bg-gradient-custom fixed-top py-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Jawi<span>Que</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="input-group mx-auto mt-5 mt-lg-0">
                <input type="text" class="form-control" placeholder="Cari..."
                    aria-label="Cari..." aria-describedby="button-addon2">
                <button class="btn btn-outline-warning" type="button" id="button-addon2">
                    <i class='bx bx-search-big'></i>
                </button>
            </div>

            <ul class="navbar-nav ms-auto mt-3 mt-sm-0">
                <li class="nav-item me-3">
                    <a class="nav-link active" href="#">
                        <i class='bx bx-heart bx-rotate-90 bx-flip-horizontal'></i>
                    </a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link" href="#">
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
                        <li><a class="dropdown-item" href="#">Home</a></li>
                        <li><a class="dropdown-item" href="#">Best Seller</a></li>
                        <li><a class="dropdown-item" href="#">New Arrival</a></li>
                        <li><a class="dropdown-item" href="#">Blog</a></li>
                    </ul>
                </div>

                @guest
                    <li class="nav-item mt-5 mt-lg-0">
                        <a class="nav-link btn-second me-lg-3 text-center" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                        <a class="nav-link btn-first text-center" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item mt-5 mt-lg-0">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link btn-second me-lg-3 text-center" 
                                style="background: none; border: none; padding: 0;">
                                Logout ({{ Auth::user()->name }})
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
