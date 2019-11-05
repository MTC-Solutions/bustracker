@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="row">

    @if (Auth::user()->hasRole("ROLE_DRIVER"))
    <div class="col-md-6 profile"> 
            <div class="register-box-body">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="fa fa-user"></i>
                        Personal Details
                    </h4>
                    @php
                        $date = $driver->date_of_birth;
                        $createDate = new DateTime($date);
    
                    @endphp
                    <hr>
                    <b>First Name</b><br>
                    <span>{{$driver->firstName}}</span><br>
                    <b>Last Name</b><br>
                    <span>{{$driver->lastName}}</span><br>
                    <b>Email</b><br>
                    <span>{{$driver->email}}</span><br>
                    <b>Age</b><br>
                    <span>{{$driver->age}}</span><br>
                    <b>Hired Date</b><br>
                    <span>{{$createDate->format("Y-m-d")}}</span><br>
                </div>
            </div> 
            
            <div class="register-box-body">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fa fa-bus"></i>
                            Update Profile
                        </h4>
                        <hr>
                        <form action="{{ route('updateDriver', $driver->id) }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="firstName">First Name</label>
                                        <div class="form-group has-feedback {{ $errors->has('firstName') ? 'has-error' : '' }}">
                                            <input type="text" name="firstName" class="form-control" value="{{ $driver->firstName }}"
                                                   placeholder="First Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" title="Numbers  and special charactors are not allowed.">
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                            @if ($errors->has('firstName'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('firstName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="lastName">Last Name</label>
                                        <div class="form-group has-feedback {{ $errors->has('lastName') ? 'has-error' : '' }}">
                                            <input type="text" name="lastName" class="form-control" value="{{ $driver->lastName }}"
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
                                        <div class="col-md-12">
                                            <label for="age">Age</label>
                                                <div class="form-group has-feedback {{ $errors->has('age') ? 'has-error' : '' }}">
                                                    <input type="text" name="age" class="form-control" value="{{ $driver->age }}"
                                                           placeholder="Age" min="22" max="65">
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                    @if ($errors->has('age'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('age') }}</strong>
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
                </div>
        </div>
        <div class="col-md-6"> 
                <div class="register-box-body">
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="fa fa-bus"></i>
                                Bus
                            </h4>
                            @php
                                $date = $driver->date_of_birth;
                                $createDate = new DateTime($date);
            
                            @endphp
                            <hr>
                            @if ($driver->bus)
                                <b>Number plate</b><br>
                                <span>{{$driver->bus->numberPlate}}</span><br>
                                <b>Model</b><br>
                                <span>{{$driver->bus->model}}</span><br>
                                <b>Maker</b><br>
                                <span>{{$driver->bus->busMaker}}</span><br>
                                <b>Number of Seats</b><br>
                                <span>{{$driver->bus->numberOfSeats}}</span><br>
                            @else
                                <a class="btn btn-warning" href="{{route("assignBusPageDriver", $driver->id)}}">Assign Bus <i class="fa fa-bus"></i> </a>
                            @endif
                        </div>
                    </div>

                    <div class="register-box-body">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <i class="fa fa-bus"></i>
                                    Trip
                                </h4>
                                @php
                                    $date = $driver->date_of_birth;
                                    $createDate = new DateTime($date);
                
                                @endphp
                                <hr>
                                @if ($driver->bus)
                                    @if ($driver->bus->trip)
                                        <b>Origin</b><br>
                                        <span>{{$driver->bus->trip->origin}}</span><br>
                                        <b>Destination</b><br>
                                        <span>{{$driver->bus->trip->destination}}</span><br>
                                        <b>Departure time</b><br>
                                        <span>{{$driver->bus->trip->departureTime}}</span><br>
                                    @else
                                        No trip assigned yet.
                                    @endif
                                @else
                                   No bus assigned yet. 
                                @endif
                            </div>
                        </div>
        </div>
    @else
    <div class="col-md-6 profile"> 
            <div class="register-box-body">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="fa fa-user"></i>
                        Personal Details
                    </h4>
                    <hr>
                    <b>First Name</b><br>
                    <span>{{$passenger->firstName}}</span><br>
                    <b>Last Name</b><br>
                    <span>{{$passenger->lastName}}</span><br>
                    <b>Email</b><br>
                    <span>{{$passenger->email}}</span><br>
                    <br>
                </div>
            </div> 
        </div>
        <div class="col-md-6"> 
                <div class="register-box-body">
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="fa fa-bus"></i>
                                Update Profile
                            </h4>
                            <hr>
                            <form action="{{ route('updatePassenger', $passenger->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback {{ $errors->has('firstName') ? 'has-error' : '' }}">
                                                <input type="text" name="firstName" class="form-control" value="{{ $passenger->firstName}}"
                                                       placeholder="First Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" oninvalid="setCustomValidity('Please enter on alphabets only. ')">
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                @if ($errors->has('firstName'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('firstName') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback {{ $errors->has('lastName') ? 'has-error' : '' }}">
                                                <input type="text" name="lastName" class="form-control" value="{{ $passenger->lastName }}"
                                                       placeholder="Last Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" oninvalid="setCustomValidity('Please enter on alphabets only. ')">
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                @if ($errors->has('lastName'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('lastName') }}</strong>
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
                    </div>
        </div> 
    @endif
    </div>

     
@stop