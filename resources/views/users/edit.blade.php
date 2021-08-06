@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit User</h2>
        </div><br>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a><br><br>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif



<form action="{{route('users.update',$user->id)}}" method="POST">
    @csrf
    @method('PUT')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Nama</label>
            <input type="text" value="{{$user->name}}" class="form-control" name="name">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" value="{{$user->email}}" name="email">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Password</label>
            <input type="password" class="form-control" name="confirm-password">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <label for="exampleInputEmail1" class="form-label">Role</label>
        <select name="roles[]" class="form-control" aria-label="Default select example">
        <option>Pilih role guys</option>
        @foreach($roles as $data)
        <option value="{{$data->name}}" {{($data->name === $userRole->name) ? 'Selected' : ''}}>{{$data->name}}</option>
        @endforeach
        </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
</div>
@endsection