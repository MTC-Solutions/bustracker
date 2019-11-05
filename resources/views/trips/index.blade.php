@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
    @if (Auth::user()->hasRole("ROLE_ADMIN"))
        <div class="float-md-right">
            <a href="{{route('createTrip')}}" class="btn btn-success btn-sm">Add Trip</a>
        </div> 
    @endif
@stop

@section('content')
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of trips</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Origin</th>
              <th>Destination</th>
              <th>Departure time</th>
              <th>Started</th>
              <th>Ended</th>
              <th>Allocated bus</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($trips as $trip)
                  <tr>
                    <td>{{$trip->id}}</td>
                    <td>{{$trip->origin}}</td>
                    <td>{{$trip->destination}}</td>
                    <td>
                        {{$trip->departureTime}}    
                    </td>
                    <td>
                        @if ($trip->started)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        @if ($trip->ended)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        @if ($trip->bus)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        @if (Auth::user()->hasRole("ROLE_DRIVER"))
                            @if (!$trip->started)
                                <a href="{{route('startTrip', $trip->id)}}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to start the journey and be tracked?');">
                                    Start trip
                                </a>                
                            @endif

                            @if (!$trip->ended && $trip->started)
                                <a href="{{route('endTrip', $trip->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to end the journey and tracking?');">
                                    End trip
                                </a>
                            @endif
                        @endif
                        
                        <a href="{{route('editTrip', $trip->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{route('deleteTrip', $trip->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete trip origin {{$trip->origin}} {{$trip->destination}}?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
            <tfoot>
              <tr>
                    <th>ID</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure time</th>
                    <th>Started</th>
                    <th>Ended</th>
                    <th>Allocated bus</th>
                    <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
@stop