@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:19
     */
@endphp

<!-- Mainly styles -->
@vite(['resources/sass/app.scss', 'node_modules/animate.css/animate.css'])
@yield('styles-before')
@if($auth_check)

@endif
<!-- App -->
@vite(['resources/css/style.css', 'resources/css/app.css'])
@yield('styles-after')