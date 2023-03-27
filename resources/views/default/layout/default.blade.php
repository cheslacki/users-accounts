@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 13:28
     *
     * Include default scripts for page.
     */

    $title_page = (env('DOMAIN_TITLE') ? env('DOMAIN_TITLE') : config('services.domain.title')) . ' | ' . (isset($title) && !empty($title) ? $title : 'Page');
@endphp

<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8">
<![endif]-->
<!--[if IE 9]>
<html class="ie ie9">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
    <head>
        <title>{{ $title_page }}</title>
        @yield('metes')
        @yield('favicons')
        @yield('styles')
    </head>
    <body @if(isset($class_body))class="{{ $class_body }}"@endif>
    <div id="app">
        @yield('content')
    </div>
    @yield('scripts')
    </body>
</html>