@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                {!! finput('name', 'Name', fvalue($data, 'name'), '', true) !!}
                {!! finput('email', 'E-mail address', fvalue($data, 'email'), '', true) !!}
                {!! finput('phone', 'Phone number', fvalue($data, 'phone')) !!}

                {!! fimage('image', 'Image of Employee', fvalue($data, 'image')) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('employees')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
