@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 11:34
     */

    $current_user = AuthHelper::getCurrentUser();
@endphp

<li class="nav-header">
    <div class="dropdown profile-element">
        {{-- Here algorithm for check '$current_user->profile->slug' for alt image. --}}
        {{ Html::image(AuthHelper::getAvatar($current_user), __('text.alt'), ['class' => 'rounded-circle img-48']) }}
        <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
            <span class="block m-t-xs font-bold text-truncate">{{ ((isset($current_user->name) && !empty($current_user->name)) ? $current_user->name : __('text.user')) }}</span>
        </a>
        <ul class="dropdown-menu animate__animated animate__fadeInRight m-t-xs">
            <li><a class="dropdown-item" href="javascript:void(0);">Profile</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">Contacts</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">Mailbox</a></li>
            <li class="dropdown-divider"></li>
            <li>
                {{ Html::link(route('logout'), __('link.logout'), ['class' => 'dropdown-item']) }}
            </li>
        </ul>
    </div>
    <div class="logo-element">
        {{ ((isset($current_user->name) && !empty($current_user->name)) ? FormatHelper::formatInitials($current_user->name) : 'UC+') }}
    </div>
</li>