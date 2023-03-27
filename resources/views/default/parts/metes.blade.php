@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:18
     */

    $keywords = [
        'Users',
        'Accounts'
    ];

    $keywords = implode(', ', $keywords);
@endphp

{{ Html::meta(null, null, ['charset' => 'utf-8']) }}
{{ Html::meta(null, 'IE=edge', ['http-equiv' => 'X-UA-Compatible']) }}
<!-- Mobile settings -->
{{ Html::meta('viewport', 'width=device-width, initial-scale=1.0') }}
{{ Html::meta('author', 'Leonardo Cheslacki') }}
{{ Html::meta('description', (isset($description) && !empty($description) ? $description : '')) }}
@if(!$auth_check)
    {{ Html::meta('keywords', (isset($keywords) && !empty($keywords) ? $keywords : '')) }}
@endif
{{ Html::meta('csrf-token', csrf_token()) }}