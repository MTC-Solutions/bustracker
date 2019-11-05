@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
  @if (Auth::user()->hasRole("ROLE_ADMIN"))
    <div class="float-md-right">
        <a href="{{route('createDriver')}}" class="btn btn-success btn-sm">Add Driver</a>
        <div class="col-md-3 justify-content-end">
            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">Export</a>
        </div>
    </div> 
  @endif
@stop

@section('content')
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of drivers having buses</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Date Hired</th>
              <th>Age</th>
              <th>Email</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($drivers as $driver)
                  @if ($driver->bus)
                    <tr>
                      <th>{{$driver->id}}</th>
                      <td>{{$driver->firstName}}</td>
                      <td>{{$driver->lastName}}</td>
                      <td>{{$driver->hireDate}}</td>
                      <td>{{$driver->age}}</td>
                      <td>{{$driver->email}}</td>
                      <td>
                          <a href="{{route("unassignBus", $driver->bus->id)}}" class="btn btn-warning btn-sm">Unassign bus <i class="fa fa-bus"></i></a>
                        <a href="{{route("showDriver", $driver->id)}}" class="btn btn-success btn-sm">View <i class="fa fa-eye"></i></a>
                          <a href="{{route('editDriver', $driver->id)}}" class="btn btn-primary btn-sm">
                              <i class="fa fa-edit"></i>
                          </a>
                        <a href="{{route('deleteDriver', $driver->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete driver {{$driver->lastName}} {{$driver->firstName}}');">
                              <i class="fa fa-trash"></i>
                          </a>
                      </td>
                    </tr>
                  @endif                  
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Hired</th>
                <th>Age</th>
                <th>Email</th>
                <th></th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

      <div class="box">
          <div class="box-header">
            <h3 class="box-title">List of drivers without buses</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Hired</th>
                <th>Age</th>
                <th>Email</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
                  @foreach ($drivers as $driver)
                    @if (!$driver->bus)
                      <tr>
                        <td>{{$driver->id}}</td>
                        <td>{{$driver->firstName}}</td>
                        <td>{{$driver->lastName}}</td>
                        <td>{{$driver->hireDate}}</td>
                        <td>{{$driver->age}}</td>
                        <td>{{$driver->email}}</td>
                        <td>
                          <a href="{{route("assignBusPageDriver", $driver->id)}}" class="btn btn-warning btn-sm">Assign bus <i class="fa fa-bus"></i></a>
                          <a href="{{route("showDriver", $driver->id)}}" class="btn btn-success btn-sm">View <i class="fa fa-eye"></i></a>  
                          <a href="{{route('editDriver', $driver->id)}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        <a href="{{route('deleteDriver', $driver->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete driver {{$driver->lastName}} {{$driver->firstName}}?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                      </tr> 
                    @endif                   
                  @endforeach
              </tbody>
              <tfoot>
              <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Date Hired</th>
                  <th>Age</th>
                  <th>Email</th>
                  <th></th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>

    @php
        $all = "ALL";
        
        $age = "AGE";
        $dateHired = "DATE_HIRED";
        //in between inclusive and exclusive 
        $inBetweenExclusive = "IN_BETWEEN_EXCLUSIVE";
        $inBetweenInclusive = "IN_BETWEEN_INCLUSIVE";

        //greater or less inclusive
        $greaterThanInclusive = "GREATER_THAN_INCLUSIVE";
        $lessThanInclusive = "LESS_THAN_INCLUSIVE";

        //greater or less exclusive
        $greaterThanExclusive = "GREATER_THAN_EXCLUSIVE";
        $lessThanExclusive = "LESS_THAN_INCLUSIVE";
    @endphp

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Customize Report</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("print-driver-report")}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="type">File Type</label>
                            <select name="type" class="form-control">
                                <option value="PDF">PDF</option>
                                <option value="Excel">Excel</option>
                            </select>
                            <label for="filterBy">Filter By</label>
                            <select name="filterBy" class="form-control">
                                <option value="{{$all}}">All</option>
                                <option value="{{$age}}">Age</option>
                            </select>

                            <label for="condition">Condition</label>
                            <select id="condition" name="condition" class="form-control">
                                <option value="{{$all}}">All</option>
                                <option class="in_between" value="{{$inBetweenInclusive}}">In between inclusive</option>
                                <option class="in_between" value="{{$inBetweenExclusive}}">In between exclusive</option>
                                <option class="not_in_between" value="{{$greaterThanInclusive}}">Greater than Inclusive</option>
                                <option class="not_in_between" value="{{$lessThanExclusive}}">Less than Exclusive</option>
                                <option class="not_in_between" value="{{$lessThanInclusive}}">Less than Inclusive</option>
                            </select>
                        </div>
    
                        <div class="form-group">
                            <div id="in_between">
                                <label for="parameter">Parameters</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class= "form-control" name="min" placeholder="Minimum Value">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class= "form-control" name="max" placeholder="Maximum Value">
                                    </div>
                                </div>
                            </div>
                            <div id="not_in_between">
                                    <label for="parameter">Parameters</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="number" class= "form-control" name="value" placeholder="Value">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Download
                            </button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>


          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
          <script>
              $(document).ready(function(){
    
                $("#condition").change(function(){
                    var selectedValue = $(this).children("option:selected").val();
                    if(selectedValue == "IN_BETWEEN_EXCLUSIVE" || selectedValue == "IN_BETWEEN_INCLUSIVE"){
                        $("#in_between").fadeIn();
                        $("#not_in_between").fadeOut();
                    }else{
                        $("#in_between").fadeOut();
                        $("#not_in_between").fadeIn();
                    }
                });
    
    
                $("#in_between").hide();
                $("#not_in_between").hide();
            });
          </script>
@stop