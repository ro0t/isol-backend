@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('products.new', 'New product') !!}

            <div class="igw-table-action">
                <a href="{{route('products')}}?status={!! $status == 1 ? 2 : 1 !!}" class="btn btn-create btn-toggle">
                    @if($status == 1)
                    <span>View unpublished</span>
                    @else
                    <span>View published</span>
                    @endif
                </a>
            </div>

        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Product</td>
                        <td>Published?</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->navision_id}}</td>
                        <td>{{$product->name}}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" data-url="{{route('products.setWebsiteVisibility', $product->id)}}" {!! isChecked($product->active == 1) !!}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td align="right">
                            <a href="{{route('products.edit', $product->id)}}">Edit</a>
                            <a href="{{route('products.delete', $product->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
