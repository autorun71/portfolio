@extends('admin::layouts.content')

@section('page_title')
    {{ __('region::app.section.main.edit-title') }} - {{ $region->name }}
@stop

@section('content')

    <div class="content">

        <form method="POST" action="{{ route('admin.region.update', $region->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('region::app.section.main.edit-title') }} - {{ $region->name }}
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

{{--                    {!! view_render_event('bagisto.admin.settings.locale.edit.before', ['locale' => $region]) !!}--}}

                    <input name="_method" type="hidden" value="PUT">

                    <accordian :title="'{{ __('region::app.default.general') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('alias') ? 'has-error' : '']">
                                <label for="alias" class="required">{{ __('region::app.section.main.fields.alias') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="alias" name="alias" data-vv-as="&quot;{{ __('admin::app.section.main.fields.alias') }}&quot;" value="{{ old('alias') ?: $region->alias }}" disabled="disabled"/>
                                <input type="hidden" name="alias" value="{{ $region->alias }}"/>
                                <span class="control-error" v-if="errors.has('alias')">@{{ errors.first('alias') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('region::app.section.main.fields.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('region::app.section.main.fields.name') }}&quot;" value="{{ old('name') ?: $region->name }}"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="channels">Список сайтов</label>
                                <select type="text" class="control" name="channels[]" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.channel') }}&quot;" multiple="multiple">
                                    <option value="0" {{ empty($selectedOptionIds) ? 'selected' : '' }}>
                                        Не выбрано
                                    </option>
                                    @foreach(app('Webkul\Core\Repositories\ChannelRepository')->all() as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $selectedOptionIds) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="control-group" :class="[errors.has('enable') ? 'has-error' : '']">
                                <label for="enable" class="required">{{ __('region::app.section.main.fields.enable') }}</label>
                                <select v-validate="'required'" class="control" id="enable" name="enable" data-vv-as="&quot;{{ __('region::app.section.main.fields.enable') }}&quot;">
                                    <option value="0" {{ (old('enable') ?: $region->enable) == '0' ? 'selected' : '' }}>Деактивирован</option>
                                    <option value="1" {{ (old('enable') ?: $region->enable) == '1' ? 'selected' : '' }}>Активен</option>
                                </select>
                                <span class="control-error" v-if="errors.has('enable')">@{{ errors.first('enable') }}</span>
                            </div>



                        </div>
                    </accordian>
                    <accordian :title="'{{ __('region::app.section.main.property') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group">
                                <label for="channels_id">Сайт:</label>
                                <select class="control" id="channel-switcher" name="channels_id" onchange="reloadPage('channel', this.value)" >


                                    @foreach (core()->getAllChannels() as $channelModel)

                                        <option
                                            value="{{ $channelModel->id }}" {{ (isset($channel) && ($channelModel->id) == $channel) ? 'selected' : '' }}>
                                            {{ $channelModel->name }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="controll-group">
                                <a href="{{ route('admin.region.props.create') }}">Добавить свойство</a>
                            </div>
                            @foreach($props as $prop)
                                @php /** @var \Webkul\Region\Models\RegionProps $prop */
                                    $propValue = $prop->value ?: ''
                                @endphp
                                <div class="control-group">
                                    <label for="name">{{ $prop->name }}</label>
                                    <input type="hidden" name="props[{{ $prop->id }}][id]" value="{{ $prop->id }}">
                                    <input type="hidden" name="props[{{ $prop->id }}][name]" value="{{ $prop->name }}">
                                    <input type="hidden" name="props[{{ $prop->id }}][code]" value="{{ $prop->code }}">

                                    <input  class="control" placeholder="{{ $prop->placeholder }}" id="{{ $prop->code }}" name="props[{{ $prop->id }}][value]" data-vv-as="&quot;{{ $prop->name }}&quot;" value="{{ old($prop->code) ?: $prop->value }}"/>
                                    <span class="control-error" v-if="errors.has('{{ $prop->code }}')">@{{ errors.first('$prop->code') }}</span>
                                </div>

                            @endforeach
                        </div>
                    </accordian>
{{--                    {!! view_render_event('bagisto.admin.settings.locale.edit.after', ['locale' => $region]) !!}--}}
                </div>
            </div>
        </form>


    </div>


@stop

@push('scripts')
    <script>

        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);
            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }

    </script>
@endpush