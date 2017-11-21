@extends('layouts.app')

@section('head')
<script src="{{asset('vendor/trumbowyg/trumbowyg.min.js')}}"></script>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <form method="post">
                {{ csrf_field() }}

                {!! ftextarea('content', 'Content', $pageContent) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('home')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
