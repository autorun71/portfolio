@extends('admin::layouts.content')

@section('page_title')
    {{ __('region::app.main.add-title') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.region.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('region::app.section.main.add-title') }}
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
                            <div class="control-group" :class="[errors.has('alias') ? 'has-error' : '']">
                                <label for="alias" class="required">{{ __('region::app.section.main.fields.alias') }}</label>
                                <input v-validate="'required'" class="control" id="alias" name="alias" data-vv-as="&quot;{{ __('admin::app.section.main.fields.alias') }}&quot;" v-alias/>
                                <span class="control-error" v-if="errors.has('alias')">@{{ errors.first('alias') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.main.fields.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('admin::app.section.main.fields.name') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('enable') ? 'has-error' : '']">
                                <label for="enable" class="required">{{ __('region::app.section.main.fields.enable') }}</label>
                                <select v-validate="'required'" class="control" id="enable" name="enable" data-vv-as="&quot;{{ __('admin::app.section.main.fields.enable') }}&quot;">
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