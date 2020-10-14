@extends('admin::layouts.content')

@section('page_title')
    {{ __('region::app.section.props.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('region::app.section.props.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.region.props.create') }}" class="btn btn-lg btn-primary">
                    {{ __('region::app.default.create') }}
                </a>
            </div>
        </div>

        <div class="page-content">

            @inject('props','Webkul\Region\DataGrids\RegionPropsDataGrid')
            {!! $props->render() !!}
        </div>
    </div>

@stop

@push('scripts')





@endpush