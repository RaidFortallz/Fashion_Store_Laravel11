
<!-- Menu Header -->
<div class="container menu-wrapper fixed-top d-none d-lg-block">
        <div class="menu d-flex justify-content-center align-items-center">
            <a class="nav-link active" href="#">Home</a>
            <a class="nav-link" href="#">Best Seller</a>
            <a class="nav-link" href="#">New Arrival</a>
            <a class="nav-link" href="#">Blog</a>
        </div>
    </div>

    <!-- Slide Header -->
    <section class="header">
        <div class="container">
            <div id="product-images" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#product-images" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#product-images" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#product-images" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="2100">
                        <img src="{{ asset('themes/jawique/assets/img/jawir.png') }}" class="d-block w-100 carousel-img" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="2100">
                        <img src="{{ asset('themes/jawique/assets/img/banner2.jpg') }}" class="d-block w-100 carousel-img" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="2100">
                        <img src="{{ asset('themes/jawique/assets/img/banner3.jpg') }}" class="d-block w-100 carousel-img" alt="...">
                    </div>
                    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#product-images"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#product-images"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>