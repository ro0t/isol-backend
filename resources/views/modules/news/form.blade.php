@extends('layouts.app')

@section('head')
<script src="{{asset('vendor/trumbowyg/trumbowyg.min.js')}}"></script>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {!! ferrors() !!}
        <div class="col-md-24">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                        {!! finput('title', 'Title', fvalue($data, 'title'), '', true) !!}
                        {!! ftextarea('content', 'Content', fvalue($data, 'content'), 'strong|underline|em|link', true) !!}
                    </div>
                    <div class="col-md-3">
                        {!! fimage('image', 'Picture', fvalue($data, 'image')) !!}
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('news')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
