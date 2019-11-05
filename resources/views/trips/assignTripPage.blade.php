@extends('adminlte::page')

@section('title', 'Create bus')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Assign</b> bus to a trip</a>
    </div>

    <div class="register-box-body">
    <p class="login-box-msg">Select a trip you wanna assign a bus. Bus number: {{$bus->busNumber}} - Number plate: {{$bus->numberPlate}}</p>
        <form action="{{ route('assignTrip', $bus->id) }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                    <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('trip') ? 'has-error' : '' }}">
                                <select name="trip"  class="form-control">
                                    @foreach ($trips as $trip)
                                <option value="{{$trip->id}}">{{$trip->origin}} - {{$trip->destination}}, Departure time: {{$trip->departureTime}}</option> 
                                    @endforeach
                                </select>   
                                @if ($errors->has('trip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('trip') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            </div>

            <button type="submit" class="btn btn-primary btn-flat">
                Assign Trip
            </button>
        </form>
    </div>
    <!-- /.form-box -->
</div><!-- /.register-box -->
@stop