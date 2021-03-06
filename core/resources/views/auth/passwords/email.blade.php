@extends('layouts.app') 

<!-- Main Content --> 
@section('content')
<div class="wrapper-page">
  <div class="text-center"> <a href="{{ url('/') }}" class="logo logo-lg">{!! config('app.icon') !!} <span>{{ config('app.name', 'Platform') }}</span> </a> </div>
  <form class="text-center m-t-20" role="form" method="POST" action="{{ url('/password/email') }}">
    {{ csrf_field() }}
    
    @if (session('status'))
    <div class="alert alert-success"> {{ session('status') }} </div>
    @else
    <div class="alert alert-success"> {{ trans('global.reset_password_info') }} </div>
    @endif
    <div class="form-group m-b-0{{ $errors->has('email') ? ' has-error' : '' }}">
      <div class="input-group">
        <input type="email" class="form-control" placeholder="{{ trans('global.enter_email') }}" name="email" value="{{ old('email') }}" required>
        <i class="material-icons form-control-feedback l-h-34" style="left:6px;z-index: 99;">&#xE0BE;</i> <span class="input-group-btn">
        <button type="submit" class="btn btn-email btn-primary waves-effect waves-light">{{ trans('global.reset') }}</button>
        </span> </div>
      @if ($errors->has('email')) <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span> @endif </div>
  </form>
  <div class="form-group m-t-30">
    <div class="col-sm-7"> <a href="{{ url('/login') }}" class="text-muted"><i class="fa fa-sign-in m-r-5"></i> {{ trans('global.log_in') }}</a> </div>
    <div class="col-sm-5 text-right"> <a href="{{ url('/register') }}" class="text-muted">{{ trans('global.create_account') }}</a> </div>
  </div>
</div>
@endsection 