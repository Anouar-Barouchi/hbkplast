@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('slider::sliders.slider')]))
    @slot('subtitle', $slider->name)

    <li><a href="{{ route('admin.sliders.index') }}">{{ trans('slider::sliders.sliders') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('slider::sliders.slider')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.mobile_sliders.store') }}" class="form-horizontal" enctype="multipart/form-data" id="slider-edit-form" novalidate>
        {{ csrf_field() }}
        <div class="media-picker-divider"></div>
        @include('media::admin.image_picker.multiple', [
            'title' => trans('slider::sliders.images'),
            'inputName' => 'files[images][]',
            'files' => $slider->images,
        ])
        <div class="media-picker-divider"></div>

        <div class="mt-5">
            <button type="submit" class="btn btn-lg btn-primary btn-save-changes" data-loading>
                {{ trans('storefront::account.profile.save_changes') }}
            </button>
        </div>
        
    </form>
@endsection



