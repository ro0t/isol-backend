@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('users.new', 'Add user') !!}
        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>User</td>
                        <td>Type</td>
                        <td>E-mail</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->super_admin ? 'Super administrator' : 'Administrator'}}</td>
                        <td>{{$user->email}}</td>
                        <td align="right">
                            <a href="{{route('users.edit', $user->id)}}">Edit</a>
                            @if(!$user->super_admin)
                            <a href="{{route('users.delete', $user->id)}}" class="delete">Delete</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
