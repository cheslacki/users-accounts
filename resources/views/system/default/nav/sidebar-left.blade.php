@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 11:10
     *
     * Generator of menu from MenuHelper.
     */
@endphp

<nav class="navbar-default navbar-static-side">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            @include('system.default.nav.elements.sidebar-left-header')
            @foreach(MenuHelper::get() as $value_one)
                @if(array_key_exists('route', $value_one) && !empty($value_one['route']) && !array_key_exists('sub_menu', $value_one))
                    <li @if(array_key_exists('active', $value_one) && $value_one['active'])class="mm-active"@endif>
                        {{ Html::link(route($value_one['route']), (Html::tag('i', '', ['class' => ('fa ' . ((array_key_exists('icon', $value_one) && !empty($value_one['icon'])) ? $value_one['icon'] : 'fa-diamond'))]) . Html::tag('span', __($value_one['lang']), ['class' => 'nav-label'])), ['title' => __($value_one['lang'])], null, false) }}
                    </li>
                @elseif(array_key_exists('route', $value_one) && empty($value_one['route']) && array_key_exists('sub_menu', $value_one) && !empty($value_one['sub_menu']))
                    <li @if(array_key_exists('active', $value_one) && $value_one['active'])class="mm-active"@endif>
                        {{ Html::link('#', (Html::tag('i', '', ['class' => ('fa ' . ((array_key_exists('icon', $value_one) && !empty($value_one['icon'])) ? $value_one['icon'] : 'fa-diamond'))]) . Html::tag('span', __($value_one['lang']), ['class' => 'nav-label'])), ['class' => 'has-arrow', 'aria-expanded' => ((array_key_exists('active', $value_one) && $value_one['active']) ? 'true' : 'false'), 'title' => __($value_one['lang'])], null, false) }}
                        <ul class="nav nav-second-level mm-collapse{{ ((array_key_exists('active', $value_one) && $value_one['active']) ? ' mm-show': '') }}">
                            @foreach($value_one['sub_menu'] as $value_two)
                                @if(array_key_exists('route', $value_two) && !empty($value_two['route']) && !array_key_exists('sub_menu', $value_two))
                                    <li @if(array_key_exists('active', $value_two) && $value_two['active'])class="mm-active"@endif>
                                        {{ Html::link(route($value_two['route']), __($value_two['lang'])) }}
                                    </li>
                                @elseif(array_key_exists('route', $value_two) && empty($value_two['route']) && array_key_exists('sub_menu', $value_two) && !empty($value_two['sub_menu']))
                                    <li @if(array_key_exists('active', $value_two) && $value_two['active'])class="mm-active"@endif>
                                        {{ Html::link('#', (Html::tag('span', __($value_two['lang']))), ['class' => 'has-arrow', 'aria-expanded' => ((array_key_exists('active', $value_one) && $value_one['active']) ? 'true' : 'false')], null, false) }}
                                        <ul class="nav nav-third-level mm-collapse{{ ((array_key_exists('active', $value_two) && $value_two['active']) ? ' mm-show': '') }}">
                                            @foreach($value_two['sub_menu'] as $value_three)
                                                @if(array_key_exists('route', $value_three) && !empty($value_three['route']) && !array_key_exists('sub_menu', $value_three))
                                                    <li @if(array_key_exists('active', $value_three) && $value_three['active'])class="mm-active"@endif>
                                                        {{ Html::link(route($value_three['route']), __($value_three['lang'])) }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>