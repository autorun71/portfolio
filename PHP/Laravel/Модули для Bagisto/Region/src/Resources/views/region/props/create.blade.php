@extends('admin::layouts.content')

@section('page_title')
    {{ __('region::app.main.add-title') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.region.props.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('region::app.section.props.add-title') }}
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

{{--                    {!! view_render_event('bagisto.admin.settings.locale.create.before') !!}--}}

                    <accordian :title="'{{ __('region::app.default.general') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                                <label for="code" class="required">{{ __('region::app.section.props.fields.code') }}</label>
                                <input v-validate="'required'" class="control" id="code" name="code" data-vv-as="&quot;{{ __('admin::app.section.props.fields.code') }}&quot;" v-code/>
                                <span class="control-error" v-if="errors.has('code')">@{{ errors.first('code') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.props.fields.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('admin::app.section.props.fields.name') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('placeholder') ? 'has-error' : '']">
                                <label for="placeholder" class="required">{{ __('region::app.section.props.fields.placeholder') }}</label>
                                <input v-validate="'required'" class="control" id="placeholder" name="placeholder" data-vv-as="&quot;{{ __('admin::app.section.props.fields.placeholder') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('placeholder')">@{{ errors.first('placeholder') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('enable') ? 'has-error' : '']">
                                <label for="enable" class="required">{{ __('region::app.section.props.fields.enable') }}</label>
                                <select v-validate="'required'" class="control" id="enable" name="enable" data-vv-as="&quot;{{ __('admin::app.section.props.fields.enable') }}&quot;">
                                    <option value="1" selected title="Text enable left to right">Активен</option>
                                    <option value="0" title="Text enable right to left">Деактивирован</option>
                                </select>
                                <span class="control-error" v-if="errors.has('enable')">@{{ errors.first('enable') }}</span>
                            </div>

                        </div>
                    </accordian>

                </div>
            </div>
        </form>
    </div>
@stop