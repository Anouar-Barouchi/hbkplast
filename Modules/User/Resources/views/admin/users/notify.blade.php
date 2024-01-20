@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::users.notify'))

    <li class="active">{{ trans('user::users.notify') }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.users.notify') }}" class="form-horizontal">
        {{ csrf_field() }}
        @method('POST')
        {{ Form::text('title', trans('user::users.title'), $errors, null, ['labelCol' => 2, 'required' => true]) }}
        {{ Form::textarea('body', trans('user::users.body'), $errors, null, ['labelCol' => 2, 'required' => true]) }}
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-primary">
                    Send
                </button>
            </div>
        </div>
    </form>
@endsection


