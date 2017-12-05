@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('employees.new', 'New employee') !!}
        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Employee</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $employee)
                    <tr>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->phone}}</td>
                        <td align="right">
                            <a href="{{route('employees.edit', $employee->id)}}">Edit</a>
                            <a href="{{route('employees.delete', $employee->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
