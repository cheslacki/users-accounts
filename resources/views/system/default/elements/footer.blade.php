@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 19:17
     */
@endphp

<div class="footer">
    <div class="float-right">
        {{ InfoHelper::getDiskSpace('free') }} @lang('text.of') <strong>{{ InfoHelper::getDiskSpace() }}</strong>
    </div>
</div>