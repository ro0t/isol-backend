@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('news.new', 'Write post') !!}
        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Created</td>
                        <td>Last updated</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $article)
                    <tr>
                        <td>{{$article->title}}</td>
                        <td>{{date('d. m. Y', strtotime($article->created_at))}}</td>
                        <td>{{date('d. m. Y', strtotime($article->updated_at))}}</td>
                        <td align="right">
                            <a href="{{route('news.edit', $article->id)}}">Edit</a>
                            <a href="{{route('news.delete', $article->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
