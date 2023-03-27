@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 11:53
     */
@endphp

<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg mb-0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to UA+</span>
            </li>
            <li class="dropdown">
                <a class="count-info" href="javascript:void(0);">
                    <i class="fa fa-envelope"></i><span class="label label-warning">16</span>
                </a>
            </li>
            <li class="dropdown">
                <a class="count-info" href="javascript:void(0);">
                    <i class="fa fa-bell"></i><span class="label label-primary">8</span>
                </a>
            </li>
            <li>
                {{ Html::link(route('logout'), (Html::tag('i', '', ['class' => 'fa fa-sign-out']) . __('link.logout')), ['title' => __('link.logout')], null, false) }}
            </li>
        </ul>
    </nav>
</div>