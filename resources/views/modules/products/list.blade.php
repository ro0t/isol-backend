@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">

            <div class="left-side">
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
                <div class="igw-table-action">
                    <a href="{{route('products.sync.all')}}" class="btn btn-create btn-toggle">
                        Sync prices
                    </a>
                </div>
            </div>

            <div class="right-side">

                <form method="get">

                    <input type="hidden" name="page" value="{{request()->get('page') == null ? 1 : request()->get('page')}}">

                    <div class="igw-table-action">
                        <div class="select">
                            <select id="product_category_id" name="product_category_id" onchange="this.form.submit()">
                                <option value="">Filter by category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ request()->get('product_category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @if($category->children)
                                    @foreach($category->children as $child)
                                    <option value="{{$child->id}}" {{ request()->get('product_category_id') == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;- {{$child->name}}</option>
                                    @endforeach
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="igw-table-action">
                        <div class="select">
                            <select id="manufacturer_id" name="manufacturer_id" onchange="this.form.submit()">
                                <option value="">Filter manufacturer</option>
                                @foreach($manufacturers as $mf)
                                <option value="{{$mf->id}}" {{ request()->get('manufacturer_id') == $mf->id ? 'selected' : '' }}>{{$mf->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

            </div>

        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Product</td>
                        <td>UnitCost</td>
                        <td>UnitPrice</td>
                        <td>UnitPriceVAT</td>
                        <td>Published?</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->navision_id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->navisionData ? formatPrice($product->navisionData->UnitCost) : 'N/A'}}</td>
                        <td>{{$product->navisionData ? formatPrice($product->navisionData->UnitPrice) : 'N/A'}}</td>
                        <td>{{$product->navisionData ? formatPrice($product->navisionData->UnitPricePerSalesUOMVAT) : 'N/A'}}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" data-url="{{route('products.setWebsiteVisibility', $product->id)}}" {!! isChecked($product->active == 1) !!}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td align="right">
                            <a href="{{route('products.sync', $product->id)}}">Sync price</a>
                            <a href="{{route('products.edit', $product->id)}}">Edit</a>
                            <a href="{{route('products.delete', $product->id)}}" class="delete">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection
