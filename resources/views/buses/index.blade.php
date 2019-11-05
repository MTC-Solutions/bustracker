@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
  @if (Auth::user()->hasRole("ROLE_ADMIN"))
    <div class="float-md-right">
        <a href="{{route('createBus')}}" class="btn btn-success btn-sm">Add Bus</a>
    </div>     
  @endif
@stop

@section('content')
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of buses</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Number plate</th>
              <th>Number of seats</th>
              <th>Model</th>
              <th>Bus Maker</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($buses as $bus)
                  <tr>
                    <td>{{$bus->id}}</td>
                    <td>{{$bus->numberPlate}}</td>
                    <td>{{$bus->numberOfSeats}}</td>
                    <td>{{$bus->model}}</td>
                    <td>{{$bus->busMaker}}</td>
                    <td>
                        @if ($bus->trip)
                        <a href="{{route("unassignBus", $bus->id)}}" class="btn btn-warning btn-sm">Unassign trip <i class="fa fa-road"></i></a> 
                        @else
                          <a href="{{route("assignTripPage", $bus->id)}}" class="btn btn-success btn-sm">Assign trip <i class="fa fa-road"></i></a> 
                        @endif
  
                        <a href="{{route('editBus', $bus->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                       <a href="{{route('deleteBus', $bus->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete the bus with number plate {{$bus->numberPlate}}?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Number plate</th>
                <th>Number of seats</th>
                <th>Model</th>
                <th>Bus Maker</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
@stop