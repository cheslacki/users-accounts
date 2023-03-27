@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 24/03/2023
     * Time: 16:20
     */
@endphp

<!-- Favicon and touch icons -->
{{ Html::favicon('images/icons/favicon.png') }}
{{ Html::favicon('images/apple-touch-icon-57-precomposed.png', ['rel' => 'apple-touch-icon-precomposed']) }}
{{ Html::favicon('images/apple-touch-icon-72-precomposed.png', ['rel' => 'apple-touch-icon-precomposed', 'sizes' => '72x72']) }}
{{ Html::favicon('images/apple-touch-icon-114-precomposed.png', ['rel' => 'apple-touch-icon-precomposed', 'sizes' => '114x114']) }}
{{ Html::favicon('images/apple-touch-icon-144-precomposed.png', ['rel' => 'apple-touch-icon-precomposed', 'sizes' => '144x144']) }}