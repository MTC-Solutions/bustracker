@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Change</b> Password Page</a>
    </div>

    <div class="register-box-body">
        <form action="{{ route('changePassword') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('currentPassword') ? 'has-error' : '' }}">
                        <input type="password" name="currentPassword" class="form-control" value="{{ old('currentPassword') }}"
                               placeholder="Current password">
                        <span class="fa fa-lock form-control-feedback"></span>
                        @if ($errors->has('currentPassword'))
                            <span class="help-block">
                                <strong>{{ $errors->first('currentPassword') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">  
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('newPassword') ? 'has-error' : '' }}">
                        <input type="password" name="newPassword" class="form-control" value="{{ old('newPassword') }}"
                               placeholder="New password">
                        <span class="fa fa-lock form-control-feedback"></span>
                        @if ($errors->has('newPassword'))
                            <span class="help-block">
                                <strong>{{ $errors->first('newPassword') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('confirmPassword') ? 'has-error' : '' }}">
                            <input data-toggle="tooltip" title="click the time icon to insert time." data-placement="bottom" type="password" name="confirmPassword" class="form-control" value="{{ old('confirmPassword') }}"
                                   placeholder="Confirm new password">
                            <span class="fa fa-lock form-control-feedback"></span>
                            @if ($errors->has('confirmPassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('confirmPassword') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            
            <button type="submit" class="btn btn-primary btn-flat">
                Submit
            </button>
        </form>
    </div>
    <!-- /.form-box -->
</div><!-- /.register-box -->
@stop