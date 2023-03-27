@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 11:08
     */
@endphp

<div id="wrapper">
    @yield('nav-left')
    <div id="page-wrapper" class="gray-bg">
        @yield('header')
        @yield('heading')
        @yield('content-wrapper')
        @yield('footer')
    </div>
</div>