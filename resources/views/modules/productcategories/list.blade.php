@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('categories.new', 'New category') !!}

            <div class="igw-table-action">
                <a href="{{route('categories.orderMenu', $depthId)}}" class="btn btn-create btn-toggle">
                    <span>Order menu categories</span>
                </a>
            </div>

        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Category</td>
                        <td>Children</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $productCategory)
                    <tr class="parent">
                        <td>
                            @if($productCategory->childCount > 0)
                                <a href="{{route('categories.depth', $productCategory->id)}}">{{$productCategory->name}}</a>
                            @else
                                {{$productCategory->name}}
                            @endif
                        </td>
                        <td>
                            @if($productCategory->childCount > 0)
                                <a href="{{route('categories.depth', $productCategory->id)}}">{{$productCategory->childCount}}</a>
                            @else
                                {{$productCategory->childCount}}
                            @endif
                        </td>
                        <td align="right">
                            <a href="{{route('categories.edit', $productCategory->id)}}">Edit</a>
                            <a href="{{route('categories.delete', $productCategory->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>

                    <!-- Loop through for children -->
                    @if($productCategory->childCount > 0)
                        @foreach($productCategory->children as $childCategory)
                        <tr>
                            <td class="inset-child">
                                {{$productCategory->name}}
                                <span>&raquo;</span>
                                @if($childCategory->childCount > 0)
                                <a href="{{route('categories.depth', $childCategory->id)}}">{{$childCategory->name}}</a>
                                @else
                                    {{$childCategory->name}}
                                @endif
                            </td>
                            <td>
                                @if($childCategory->childCount > 0)
                                    <a href="{{route('categories.depth', $childCategory->id)}}">{{$childCategory->childCount}}</a>
                                @else
                                    {{$childCategory->childCount}}
                                @endif
                            </td>
                            <td align="right">
                                <a href="{{route('categories.edit', $childCategory->id)}}">Edit</a>
                                <a href="{{route('categories.delete', $childCategory->id)}}" class="delete">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
