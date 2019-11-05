@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="row">
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
    </div>

     
@stop