@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 10:40
     */
@endphp

@extends('system.default.layout.default')

@section('nav-left')
    @include('system.default.nav.sidebar-left')
@stop

@section('header')
    @include('system.default.elements.header')
@stop

@section('heading')
    @include('system.default.elements.heading')
@stop

@section('content-wrapper')
    <div class="wrapper wrapper-content sheet-content animate__animated animate__fadeIn">
        <div class="row list-table">
            <div class="col-lg-12">
                <div class="ibox">
                    @include('system.default.box.box-title')
                    <div class="ibox-content">
                        {!! Form::open(['route' => 'admin.users', 'method' => 'GET']) !!}
                        @include('system.default.box.box-content-form')
                        <div class="table-responsive list-update">
                            @include('system.admin.user.list.table.users')
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('system.default.elements.footer')
@stop

{{-- Styles per page --}}
@section('styles-before-page')
    <!-- iCheck -->
    @vite('resources/vite/vendor/icheck/green.min.css')
@stop

{{-- Scripts per page --}}
@section('scripts-before-page')
    <!-- iCheck -->
    @vite('resources/vite/vendor/icheck/icheck.min.js')
@stop