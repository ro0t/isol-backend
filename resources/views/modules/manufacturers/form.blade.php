@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                {!! finput('name', 'Name', fvalue($data, 'name')) !!}
                {!! finput('website', 'Website', fvalue($data, 'website'),'Include http:// or https://') !!}
                {!! fimage('image', 'Logo', fvalue($data, 'image')) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('manufacturers')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
