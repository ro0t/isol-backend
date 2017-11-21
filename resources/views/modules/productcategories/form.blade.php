@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <form method="post">
                {{ csrf_field() }}

                {!! finput('name', 'Name', fvalue($data, 'name')) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('categories')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
