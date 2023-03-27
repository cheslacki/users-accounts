@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 13:25
     */

    $auth_check = Auth::check();
@endphp

@extends('default.layout.default', ['class_body' => 'gray-bg'])

@section('metes')
    @include('default.parts.metes', ['auth_check' => $auth_check])
@stop

@section('favicons')
    @include('default.parts.favicons')
@stop

@section('styles-before')

@stop

@section('styles-after')

@stop

@section('styles')
    @include('default.parts.styles', ['auth_check' => $auth_check])
@stop

@section('content')
    @include("system.auth.elements.content-{$page}")
@stop

@section('scripts-before')

@stop

@section('scripts-after')
    @yield('scripts-after-page')
@stop

@section('scripts')
    @include('default.parts.scripts', ['auth_check' => $auth_check])
@stop