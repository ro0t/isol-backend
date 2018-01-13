@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('categories.new', 'New category') !!}

            <div class="igw-table-action">
                <a href="{{route('categories.orderMenu')}}" class="btn btn-create btn-toggle">
                    <span>Order menu categories</span>
                </a>
            </div>

        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Category</td>
                        <td align="center">Show in menu?</td>
                        <td align="center">Show on website?</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $productCategory)
                    <tr>
                        <td>{{$productCategory->name}}</td>
                        <td align="center">
                            <label class="switch">
                                <input type="checkbox" data-url="{{route('categories.setMenuVisibility', $productCategory->id)}}" {!! isChecked($productCategory->show_menu) !!}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td align="center">
                            <label class="switch">
                                <input type="checkbox" data-url="{{route('categories.setWebsiteVisibility', $productCategory->id)}}" {!! isChecked($productCategory->show_website) !!}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td align="right">
                            <a href="{{route('categories.edit', $productCategory->id)}}">Edit</a>
                            <a href="{{route('categories.delete', $productCategory->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>

                    <!-- Loop through for children -->
                    @if(isset($productCategory->children) && count($productCategory->children) > 0)
                        @foreach($productCategory->children as $childCategory)
                        <tr>
                            <td colspan="3" class="inset-child">{{$productCategory->name}} <span>&raquo;</span> {{$childCategory->name}}</td>
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
