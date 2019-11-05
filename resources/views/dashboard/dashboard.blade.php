@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')

@stop

@section('content')


@if (Auth::user()->hasRole("ROLE_ADMIN") || Auth::user()->hasRole("ROLE_PASSENGER"))
<div class="row">
    <!-- ./col -->

    @if (Auth::user()->hasRole("ROLE_ADMIN"))
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
           <h3>{{$drivers->count()}}</h3>
  
            <p>Drivers</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="{{route("drivers")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
  
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                 <h3>{{$passengers->count()}}</h3>
        
                  <p>Passengers</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="{{route("passengers")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->        
    @endif

          <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                 <h3>{{$buses->count()}}</h3>
        
                  <p>Buses</p>
                </div>
                <div class="icon">
                  <i class="fa fa-bus"></i>
                </div>
                <a href="{{route("buses")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                   <h3>{{$trips->count()}}</h3>
          
                    <p>Trips</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-road"></i>
                  </div>
                  <a href="{{route("trips")}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
  </div>   
@else
    
@endif


<div id="mapID">

</div>
@stop