@extends('admin::layouts.content')

@section('page_title')
    {{ __('region::app.main.edit-title') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.region.props.update', $props->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('region::app.section.main.edit-title') }} - {{ $props->name }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('region::app.default.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

{{--                    {!! view_render_event('bagisto.admin.settings.locale.edit.before', ['locale' => $props]) !!}--}}

                    <input name="_method" type="hidden" value="PUT">

                    <accordian :title="'{{ __('region::app.default.general') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                                <label for="code" class="required">{{ __('region::app.section.props.fields.code') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="code" name="code" data-vv-as="&quot;{{ __('admin::app.section.props.fields.code') }}&quot;" value="{{ old('code') ?: $props->code }}" />
                                <input type="hidden" name="code" value="{{ $props->code }}"/>
                                <span class="control-error" v-if="errors.has('code')">@{{ errors.first('code') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.props.fields.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('region::app.section.props.fields.name') }}&quot;" value="{{ old('name') ?: $props->name }}"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('placeholder') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.props.fields.placeholder') }}</label>
                                <input v-validate="'required'" class="control" id="placeholder" name="placeholder" data-vv-as="&quot;{{ __('region::app.section.props.fields.placeholder') }}&quot;" value="{{ old('placeholder') ?: $props->placeholder }}"/>
                                <span class="control-error" v-if="errors.has('placeholder')">@{{ errors.first('placeholder') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('sort') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.props.fields.sort') }}</label>
                                <input v-validate="'required'" class="control" id="sort" name="sort" data-vv-as="&quot;{{ __('region::app.section.props.fields.sort') }}&quot;" value="{{ old('sort') ?: $props->sort }}"/>
                                <span class="control-error" v-if="errors.has('sort')">@{{ errors.first('sort') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('enable') ? 'has-error' : '']">
                                <label for="enable" class="required">{{ __('region::app.section.props.fields.enable') }}</label>
                                <select v-validate="'required'" class="control" id="enable" name="enable" data-vv-as="&quot;{{ __('region::app.section.props.fields.enable') }}&quot;">
                                    <option value="0" {{ (old('enable') ?: $props->enable) == '0' ? 'selected' : '' }}>Деактивирован</option>
                                    <option value="1" {{ (old('enable') ?: $props->enable) == '1' ? 'selected' : '' }}>Активен</option>
                                </select>
                                <span class="control-error" v-if="errors.has('enable')">@{{ errors.first('enable') }}</span>
                            </div>

                        </div>
                    </accordian>

{{--                    {!! view_render_event('bagisto.admin.settings.locale.edit.after', ['locale' => $props]) !!}--}}
                </div>
            </div>
        </form>
    </div>
@stop