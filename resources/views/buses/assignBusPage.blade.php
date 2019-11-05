@extends('adminlte::page')

@section('title', 'Create bus')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Assign</b> Driver</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Select a bus you wanna assign a driver.</p>
        <form action="{{ route('assignDriver', $driver->id) }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                    <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('bus') ? 'has-error' : '' }}">
                                <select name="bus"  class="form-control">
                                    @foreach ($buses as $bus)
                                        <option value="{{$bus->id}}">{{$bus->busMaker}} / {{$bus->model}} / {{$bus->numberPlate}}</option> 
                                    @endforeach
                                </select>   
                                @if ($errors->has('bus'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bus') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            </div>

            <button type="submit" class="btn btn-primary btn-flat">
                Assign Bus
            </button>
        </form>
    </div>
    <!-- /.form-box -->
</div><!-- /.register-box -->
@stop