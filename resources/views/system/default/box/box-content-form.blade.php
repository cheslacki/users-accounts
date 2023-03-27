@php
    /**
     * Created by PhpStorm.
     * User: Leonardo Cheslacki
     * Date: 26/03/2023
     * Time: 13:40
     */
@endphp

<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            {!! Form::label('filter_name', __('label.name')) !!}
            {!! Form::text('filter[name]', null, ['maxlength' => 128, 'class' => 'form-control form-control-sm', 'id' => 'filter_name']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('filter_active_yes', __('label.status')) !!}
            <div class="radio">
                <div class="form-check form-check-inline">
                    {!! Form::radio('filter[active]', 'yes', null, [ 'id' => 'filter_active_yes']) !!}
                    {!! Form::label('filter_active_yes', __('text.status.yes'), ['class' => 'form-check-label disable-select-text cursor-pointer']) !!}
                </div>
                <div class="form-check form-check-inline">
                    {!! Form::radio('filter[active]', 'no', null, [ 'id' => 'filter_active_no']) !!}
                    {!! Form::label('filter_active_no', __('text.status.no'), ['class' => 'form-check-label disable-select-text cursor-pointer']) !!}
                </div>
                <div class="form-check form-check-inline">
                    {!! Form::radio('filter[active]', 'all', true, [ 'id' => 'filter_active_all']) !!}
                    {!! Form::label('filter_active_all', __('text.status.all'), ['class' => 'form-check-label disable-select-text cursor-pointer']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1"></div>
    <div class="row align-items-end col-sm-6 pb-3">
        <div class="col mx-1 mb-2">
            {{ Form::button(__('button.search'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
        </div>
        <div class="col mx-1 mb-2">
            {{ Html::link(route('admin.users'), __('button.erase'), ['class' => 'btn btn-primary btn-block']) }}
        </div>
        <div class="col mx-1 mb-2">
            {{ Html::link(route('admin.user'), __('button.new'), ['class' => 'btn btn-primary btn-block']) }}
        </div>
    </div>
</div>