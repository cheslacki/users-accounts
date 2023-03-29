@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 23:35
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
        <div class="row form-table">
            <div class="col-lg-12">
                <div class="ibox">
                    @include('system.default.box.box-title')
                    <div class="ibox-content">
                        {{ Form::open(['route' => ['admin.user.post', 'user_id' => Request::route()->parameter('user_id')], 'method' => 'POST', 'class' => 'row', 'id' => 'form_user']) }}
                        <div class="col-12 mb-2">
                            <fieldset class="card card-body bg-light">
                                <h2>@lang('text.info_user')</h2>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    {{ Form::label('user_name', '<b class="required">*</b>&nbsp;' . __('label.name'), [], false) }}
                                                    {{ Form::text('user[name]', (isset($query->name) && !empty($query->name) ? $query->name : null), ['maxlength' => 128, 'class' => 'form-control', 'id' => 'user_name']) }}
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    {{ Form::label('user_email', '<b class="required">*</b>&nbsp;' . __('label.email'), [], false) }}
                                                    {{ Form::text('user[email]', (isset($query->email) && !empty($query->email) ? $query->email : null), ['maxlength' => 128, 'class' => 'form-control', 'id' => 'user_email']) }}
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    {{ Form::label('user_active', '<b class="required">*</b>&nbsp;' . __('label.status'), [], false) }}
                                                    {{ Form::select('user[active]', QueryHelper::getActive(), (isset($query->active) && !empty($query->active) ? $query->active : null), ['class' => 'form-control', 'placeholder' => __('placeholder.select'), 'id' => 'user_active']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    @if(!isset($query->id))
                                                        {{ Form::label('user_password', '<b class="required">*</b>&nbsp;' . __('label.password'), [], false) }}
                                                    @else
                                                        {!! Form::label('user_password', __('label.password')) !!}
                                                    @endif
                                                    {{ Form::password('user[password]', ['maxlength' => 10, 'class' => 'form-control', 'id' => 'user_password']) }}
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    @if(!isset($query->id))
                                                        {{ Form::label('user_password_confirm', '<b class="required">*</b>&nbsp;' . __('label.confirm_password'), [], false) }}
                                                    @else
                                                        {!! Form::label('user_password_confirm', __('label.confirm_password')) !!}
                                                    @endif
                                                    {{ Form::password('user[password_confirm]', ['maxlength' => 10, 'class' => 'form-control', 'id' => 'user_password_confirm']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-center justify-content-center">
                                        <div class="display-1 text-muted">
                                            <i class="fa fa-sign-in"></i>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="nav nav-pills justify-content-end mx-n1">
                                <div class="nav-item mx-1">
                                    {{ Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-primary button-submit']) }}
                                </div>
                                @if(!isset($query->id))
                                    <div class="nav-item mx-1">
                                        {{ Html::link('#', __('button.erase'), ['class' => 'btn btn-light button-erase']) }}
                                    </div>
                                @endif
                                <div class="nav-item mx-1">
                                    {{ Html::link(URL::previous(), __('button.back'), ['class' => 'btn btn-light button-default']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('system.default.elements.footer')
@stop