@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 12:04
     */

    $title = (isset($title) && !empty($title) ? $title : 'Page');
    $link = (isset($link) && !empty($link) ? $link : 'Link');
@endphp

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>{{ $title }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span>{{ $title }}</span>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{ $link }}</strong>
            </li>
        </ol>
    </div>
</div>

