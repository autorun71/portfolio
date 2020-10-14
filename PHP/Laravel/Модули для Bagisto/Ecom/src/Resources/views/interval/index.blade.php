@extends('admin::layouts.content')

@section('page_title')
    {{ __('ecom::app.section.interval.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('ecom::app.section.interval.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.region.create') }}" class="btn btn-lg btn-primary">
                    {{ __('region::app.default.create') }}
                </a>
            </div>
        </div>

        <div class="page-content">

            @inject('locales','Webkul\Ecom\DataGrids\EcomImportIntervalsDataGrid')
            {!! $locales->render() !!}
        </div>
    </div>

@stop

@push('scripts')





@endpush