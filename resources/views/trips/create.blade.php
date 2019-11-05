@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Add</b> Trip</a>
    </div>

    <div class="register-box-body">
        <form action="{{ route('saveTrip') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('origin') ? 'has-error' : '' }}">
                        <input type="text" name="origin" class="form-control" value="{{ old('origin') }}"
                               placeholder="Origin">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('origin'))
                            <span class="help-block">
                                <strong>{{ $errors->first('origin') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('destination') ? 'has-error' : '' }}">
                        <input type="text" name="destination" class="form-control" value="{{ old('destination') }}"
                               placeholder="Destination">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('destination'))
                            <span class="help-block">
                                <strong>{{ $errors->first('destination') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('departureTime') ? 'has-error' : '' }}">
                            <input id="timepicker" data-toggle="tooltip" title="click the time icon to insert time." data-placement="bottom" type="text" name="departureTime" class="form-control" value="{{ old('departureTime') }}"
                                   placeholder="Departure Time">
                            @if ($errors->has('departureTime'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('departureTime') }}</strong>
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