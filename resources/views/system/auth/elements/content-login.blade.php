@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:36
     */
@endphp

<div class="middle-box text-center loginscreen animate__animated animate__fadeInDown">
    <h1 class="logo-name">UA+</h1>
    <h3>Welcome to UA+</h3>
    <p>Login in. To see it in action.</p>
    {{ Form::open(['route' => 'login.post', 'method' => 'POST', 'class' => 'm-t', 'id' => 'form_login']) }}
        <div class="form-group">
            {{ Form::label('auth_email', null, ['style' => 'display: none;']) }}
            {{ Form::text('auth[email]', null, ['maxlength' => 128, 'class' => 'form-control', 'placeholder' => __('placeholder.email'), 'id' => 'auth_email']) }}
        </div>
        <div class="form-group">
            {{ Form::label('auth_password', null, ['style' => 'display: none;']) }}
            {{ Form::password('auth[password]', ['maxlength' => 64, 'class' => 'form-control', 'placeholder' => __('placeholder.password'), 'id' => 'auth_password']) }}
        </div>
        {{ Form::button(__('button.login'), ['type' => 'submit', 'class' => 'btn btn-primary block full-width m-b button-submit']) }}
        {{ Html::link(route('forgot.password'), Html::tag('small', __('link.forgot_password')), ['class' => 'button-default'], null, false) }}
    {{ Form::close() }}
    <p class="m-t">
        <small>Inspinia we app framework base on Bootstrap 4 &copy; 2014</small>
    </p>
</div>