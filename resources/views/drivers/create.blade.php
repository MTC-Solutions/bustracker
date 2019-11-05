@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Add</b> Driver</a>
    </div>

    <div class="register-box-body">
        <form action="{{ route('saveDriver') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('firstName') ? 'has-error' : '' }}">
                        <input type="text" name="firstName" class="form-control" value="{{ old('firstName') }}"
                               placeholder="First Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" title="Numbers  and special charactors are not allowed.">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('firstName'))
                            <span class="help-block">
                                <strong>{{ $errors->first('firstName') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('lastName') ? 'has-error' : '' }}">
                        <input type="text" name="lastName" class="form-control" value="{{ old('lastName') }}"
                               placeholder="Last Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" title="Numbers  and special charactors are not allowed.">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('lastName'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lastName') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('age') ? 'has-error' : '' }}">
                                <input type="number" name="age" class="form-control" value="{{ old('age') }}"
                                       placeholder="Age" min="22" max="65">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if ($errors->has('age'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('hireDate') ? 'has-error' : '' }}">
                                <input type="date" name="hireDate" class="form-control" value="{{ old('hireDate') }}"
                                       placeholder="Date hired">
                                @if ($errors->has('hireDate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hireDate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                </div>
            
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                               placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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