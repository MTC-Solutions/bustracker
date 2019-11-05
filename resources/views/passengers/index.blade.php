@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of passengers</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($passengers as $passenger)
                  <tr>
                    <td>{{$passenger->id}}</td>
                    <td>{{$passenger->firstName}}</td>
                    <td>{{$passenger->lastName}}</td>
                    <td>{{$passenger->email}}</td>
                    <td>
                        <a href="{{route('editPassenger', $passenger->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{route('deletePassenger', $passenger->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete passeneger {{$passenger->lastName}} {{$passenger->firstName}}?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
            <tfoot>
              <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
@stop