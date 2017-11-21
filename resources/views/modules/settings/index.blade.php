@extends('layouts.app')

@section('head')
<script src="{{asset('vendor/trumbowyg/trumbowyg.min.js')}}"></script>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                {!! fcsv('plist', 'Product list (CSV)', '') !!}
                {!! ftextarea('opening-hours', 'Opening hours', $openingHours->content, 'strong|underline|em|link') !!}
                {!! ftextarea('footer', 'Footer', $footer->content, 'strong|underline|em|link') !!}
                {!! ftextarea('emergency-number', 'Emergency number', $emergencyNumber->content, 'strong|underline|em|link') !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('settings')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
