@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:19
     */
@endphp

<!-- Mainly scripts -->
@vite('resources/js/app.js')
@yield('scripts-before')
@if($auth_check)

@endif
@yield('scripts-after')