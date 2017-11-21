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

                <div class="row">
                    <div class="col-md-6">
                        {!! finput('navision_id', 'Navision ID', fvalue($data, 'navision_id')) !!}

                        <datalist id="list-navision_id" input="navision_id" result="name" url="{{route('products.autosearch.navision')}}"></datalist>

                        {!! finput('name', 'Product name', fvalue($data, 'name')) !!}
                    </div>
                    <div class="col-md-6">
                        <label class="select--label" for="manufacturer_id">Manufacturer</label>
                        <div class="select">
                            <select id="manufacturer_id" name="manufacturer_id">
                                <option value="">Choose manufacturer</option>
                                @foreach($manufacturers as $mf)
                                <option value="{{$mf->id}}" {!! fselectvalue($mf->if, $data, 'manufacturer_id') !!}>{{$mf->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="select--label" for="product_category_id">Product Category</label>
                        <div class="select">
                            <select id="product_category_id" name="product_category_id">
                                <option value="">Choose category</option>
                                @foreach($categories as $pc)
                                <option value="{{$pc->id}}">{{$pc->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {!! ftextarea('description', 'Description', fvalue($data, 'description')) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('products')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
