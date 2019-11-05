@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Edit</b> Driver</a>
    </div>

    <div class="register-box-body">
        <form action="{{ route('updateBus', $bus->id) }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('busMaker') ? 'has-error' : '' }}">
                        <input type="text" name="busMaker" class="form-control" value="{{ $bus->busMaker }}"
                               placeholder="Bus Maker" pattern="[A-Za-z]" title="Only letters are allowed.">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('busMaker'))
                            <span class="help-block">
                                <strong>{{ $errors->first('busMaker') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('numberPlate') ? 'has-error' : '' }}">
                        <input type="text" name="numberPlate" class="form-control" value="{{ $bus->numberPlate }}"
                               placeholder="Number plate">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('numberPlate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numberPlate') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('model') ? 'has-error' : '' }}">
                        <input type="text" name="model" class="form-control" value="{{ $bus->model }}"
                               placeholder="Bus model" pattern="[a-zA-Z0-9-]+" title="Only numbers and letters are allowed.">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('model'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('numberOfSeats') ? 'has-error' : '' }}">
                        <input type="number" name="numberOfSeats" class="form-control" value="{{ $bus->numberOfSeats}}"
                               placeholder="Number of seats" min="22" max="85">
                        <span class="fa fa-envelope form-control-feedback"></span>
                        @if ($errors->has('numberOfSeats'))
                            <span class="help-block">
                                <strong>{{ $errors->first('numberOfSeats') }}</strong>
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