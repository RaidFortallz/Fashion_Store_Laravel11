<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <title>JawiQue: Fashion Store</title>
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

</body>

</html>