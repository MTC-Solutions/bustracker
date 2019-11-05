@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
<div class="register-boxl">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Edit</b> Passenger</a>
    </div>

    <div class="register-box-body">
        <form action="{{ route('updatePassenger', $passenger->id) }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('firstName') ? 'has-error' : '' }}">
                        <input type="text" name="firstName" class="form-control" value="{{ $passenger->firstName}}"
                               placeholder="First Name" pattern="^[a-zA-Z]+(\s[a-zA-Z]+)?$" title="Numbers  and special charactors are not allowed.">
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
                <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('lastName') ? 'has-error' : '' }}">
                        <input type="text" name="lastName" class="form-control" value="{{ $passenger->lastName }}"
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
            
            <button type="submit" class="btn btn-primary btn-flat">
                Submit
            </button>
        </form>
    </div>
    <!-- /.form-box -->
</div><!-- /.register-box -->

<script>

</script>
@stop