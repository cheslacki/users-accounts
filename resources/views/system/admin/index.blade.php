@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:09
     */

    $auth_check = Auth::check();
@endphp

@extends('default.layout.default')

@section('metes')
    @include('default.parts.metes', ['auth_check' => $auth_check])
@stop

@section('favicons')
    @include('default.parts.favicons')
@stop

@section('content')
    @include("system.admin.{$page}")
@stop

{{-- Styles per page --}}
@section('styles-before')
    @yield('styles-before-page')
@stop

@section('styles')
    @include('default.parts.styles', ['auth_check' => $auth_check])
@stop

{{-- Scripts per page --}}
@section('scripts-before')
    @yield('scripts-before-page')
@stop

@section('scripts')
    @include('default.parts.scripts', ['auth_check' => $auth_check])
@stop