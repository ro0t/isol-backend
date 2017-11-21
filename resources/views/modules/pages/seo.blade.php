@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <form method="post">
                {{ csrf_field() }}

                {!! finput('keywords', 'Keywords', $seo->keywords, 'Keywords for this page for search engines to register') !!}
                {!! finput('og_title', 'og:title', $seo->og_title, 'Open Graph Title (Facebook Share)') !!}
                {!! finput('og_description', 'og:description', $seo->og_description, 'Search engines will display this string in results, and facebook will display this under the title.') !!}
                {!! finput('og_type', 'og:type', $seo->og_type, 'Types: Website, Product, etc.') !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('home')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
