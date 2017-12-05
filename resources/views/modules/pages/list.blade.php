@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Page</td>
                        <td>Url</td>
                        <td align="center">SEO</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $page)
                    <tr>
                        <td>{{$page->name}}</td>
                        <td><a href="javascript:;">{{$page->url}}</a></td>
                        <td align="center"><a href="{{route('page.seo', $page->id)}}">Modify</a></td>
                        <td align="right">
                            @if($page->editable)
                            <a href="{{route('page.edit', $page->id)}}">Edit</a>
                            @else
                                @if( $page->admin_layout_key != "DEFAULT")
                                <a href="{{route('page.edit.special', strtolower($page->admin_layout_key))}}">Edit</a>
                                @else
                                <span style="text-decoration: line-through; opacity: .6">Edit</span>
                                @endif
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
