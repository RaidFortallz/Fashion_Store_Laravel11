<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- PERBAIKAN: Menggunakan link CDN Boxicons yang benar --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>JawiQue: Fashion Store</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts Buat Css & Js-->
    @vite(['resources/sass/app.scss',
            'resources/js/app.js',
            //Css
            'resources/views/themes/jawique/assets/css/main.css',
            'resources/views/themes/jawique/assets/plugins/jqueryui/jquery-ui.css',
            //Js
            'resources/views/themes/jawique/assets/js/main.js',
            'resources/views/themes/jawique/assets/plugins/jqueryui/jquery-ui.min.js',
        ])

</head>

<body>

    <!-- Bagian Navbar -->
    @include('themes.jawique.shared.header')
    
    <!-- Bagian Tengah (Menu Populer & Terbaru) -->
    @yield('content')
    
    <!-- Bagian Footer -->
    @include('themes.jawique.shared.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success') || session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success') ?? session('status')),
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Maaf',
                    text: @json(session('error')),
                    confirmButtonColor: '#ff6f61'
                });
            @endif
        });
    </script>

    @stack('scripts')

</body>

</html>
