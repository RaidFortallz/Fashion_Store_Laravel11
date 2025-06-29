<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <title>JawiQue: Fashion Store</title>
    <!-- Scripts Buat Css & Js-->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/themes/jawique/main.css'])

</head>

<body>

    <!-- Bagian Navbar -->
    @include('themes.jawique.shared.header')

    <!-- Bagian Header Menu & Slide -->
    @include('themes.jawique.shared.slider')
    
    <!-- Bagian Tengah (Menu Populer & Terbaru) -->
    @yield('content')
    
    <!-- Bagian Footer -->
    @include('themes.jawique.shared.footer')

</body>

</html>