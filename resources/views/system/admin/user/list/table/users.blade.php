@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 12:20
     */

    $current_user = AuthHelper::getCurrentUser();
@endphp

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <td colspan="4">
            <strong>@lang('pagination.paginate', ['current_page' => $query->currentPage(), 'last_page' => $query->lastPage(), 'per_page' => $query->perPage(), 'total' => $query->total()])</strong>
        </td>
        <td colspan="4">
            {{ $query->links() }}
        </td>
    </tr>
    <tr>
        <th class="width-zero checkbox">
            {{ Form::label('checkbox_all_top', null, ['style' => 'display: none;']) }}
            {{ Form::checkbox('action[checkbox][all_top]', null, null, ['id' => 'checkbox_all_top']) }}
        </th>
        <th class="width-zero"></th>
        <th>
            <a href="{{ FormatHelper::filterLink('name', $order) }}">
                <i class="fa {{ $sort == 'name' ? ($order == 'desc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>&nbsp;@lang('table.name')
            </a>
        </th>
        <th>
            <a href="{{ FormatHelper::filterLink('email', $order) }}">
                <i class="fa {{ $sort == 'email' ? ($order == 'desc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>&nbsp;@lang('table.login')
            </a>
        </th>
        <th>
            <a href="{{ FormatHelper::filterLink('active', $order) }}">
                <i class="fa {{ $sort == 'active' ? ($order == 'desc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>&nbsp;@lang('table.status')
            </a>
        </th>
        <th>
            <a href="{{ FormatHelper::filterLink('created_at', $order) }}">
                <i class="fa {{ $sort == 'created_at' ? ($order == 'desc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>&nbsp;@lang('table.created')
            </a>
        </th>
        <th>
            <a href="{{ FormatHelper::filterLink('updated_at', $order) }}">
                <i class="fa {{ $sort == 'updated_at' ? ($order == 'desc' ? 'fa-sort-asc' : 'fa-sort-desc') : 'fa-sort' }}"></i>&nbsp;@lang('table.updated')
            </a>
        </th>
        <th class="width-zero"></th>
    </tr>
    </thead>
    <tbody>
    @forelse($query as $value)
        @php
            $index = FormatHelper::randomString();
        @endphp
        <tr class="cursor-pointer view" data-id="{{ $value->id }}">
            <td class="checkbox">
                {{ Form::label("checkbox_{$index}", null, ['style' => 'display: none;']) }}
                {{ Form::checkbox('action[checkbox][]', $value->id, null, ['id' => ("checkbox_{$index}")]) }}
            </td>
            <td>{{-- Here algorithm for check '$current_user->profile->slug' for alt image. --}}
                {{ Html::image(AuthHelper::getAvatar($value), __('text.alt'), ['class' => 'rounded-circle img-sm']) }}
            </td>
            <td class="text-nowrap">
                {!! ((isset($value->name) && !empty($value->name)) ? e($value->name) : __('text.default')) !!}
            </td>
            <td>
                {!! ((isset($value->email) && !empty($value->email)) ?  e($value->email) : __('text.default')) !!}
            </td>
            <td>
                {!! ((isset($value->active) && !empty($value->active)) ?  e(__("text.status.{$value->active}")) : __('text.default')) !!}
            </td>
            <td class="text-nowrap">
                {!! ((isset($value->created_at) && !empty($value->created_at)) ?  e($value->created_at->format('d/m/Y H:i')) : __('text.default')) !!}
            </td>
            <td class="text-nowrap">
                {!! ((isset($value->updated_at) && !empty($value->updated_at)) ?  e($value->updated_at->format('d/m/Y H:i')) : __('text.default')) !!}
            </td>
            @if(isset($current_user->id) && ($current_user->id != $value->id))
                <td class="actions">
                    {{ Form::button(Html::tag('i', '', ['class' => 'fa fa-trash text-danger']), ['type' => 'button', 'class' => 'btn btn-white delete']) }}
                </td>
            @else
                <td class="actions">
                    {{ Form::button(Html::tag('i', '', ['class' => 'fa fa-trash text-muted']), ['type' => 'button', 'class' => 'btn btn-white disabled']) }}
                </td>
            @endif
        </tr>
    @empty
        <tr class="text-center">
            <td colspan="8">@lang('message.not_register')</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th class="width-zero checkbox">
            {{ Form::label('checkbox_all_bottom', null, ['style' => 'display: none;']) }}
            {{ Form::checkbox('action[checkbox][all_bottom]', null, null, ['id' => 'checkbox_all_bottom']) }}
        </th>
        <th class="width-zero"></th>
        <th>@lang('table.name')</th>
        <th>@lang('table.login')</th>
        <th>@lang('table.status')</th>
        <th>@lang('table.created')</th>
        <th>@lang('table.updated')</th>
        <th class="width-zero"></th>
    </tr>
    <tr>
        <td colspan="4">
            <strong>@lang('pagination.paginate', ['current_page' => $query->currentPage(), 'last_page' => $query->lastPage(), 'per_page' => $query->perPage(), 'total' => $query->total()])</strong>
        </td>
        <td colspan="4">
            {{ $query->links() }}
        </td>
    </tr>
    </tfoot>
</table>