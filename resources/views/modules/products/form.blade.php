@extends('layouts.app')

@section('head')
<script src="{{asset('vendor/trumbowyg/trumbowyg.min.js')}}"></script>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {!! ferrors() !!}
        <div class="col-md-24">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-3">

                        {!! finput('navision_id', 'Navision ID', fvalue($data, 'navision_id')) !!}
                        <datalist id="list-navision_id" input="navision_id" result="name" url="{{route('products.autosearch.navision')}}"></datalist>

                        {!! finput('name', 'Product name', fvalue($data, 'name'), null, true) !!}

                        {!! finput('model_number', 'Model number', fvalue($data, 'model_number')) !!}

                        <div class="input">
                            <label>Unit Prices</label>
                            <p>Unit Cost: {{ $data->navisionData ? formatPrice($data->navisionData->UnitCost) : 'N/A' }}</p>
                            <p>Unit Price: {{ $data->navisionData ? formatPrice($data->navisionData->UnitPrice) : 'N/A' }}</p>
                            <p>Unit Price VAT: {{ $data->navisionData ? formatPrice($data->navisionData->UnitPricePerSalesUOMVAT) : 'N/A' }}</p>
                            <a href="{{route('products.sync', $data->id)}}" onclick="return confirm('Are you sure you want to sync now? All current changes will be lost.')">
                                Sync prices
                            </a>
                        </div>


                        <label class="select--label" for="manufacturer_id">Manufacturer</label>
                        <div class="select">
                            <select id="manufacturer_id" name="manufacturer_id" required>
                                <option value="">Choose manufacturer</option>
                                @foreach($manufacturers as $mf)
                                <option value="{{$mf->id}}" {!! fselectvalue($mf->id, $data, 'manufacturer_id') !!}>{{$mf->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="select--label" for="product_category_id">Product Category</label>
                        <div class="select">
                            <select id="product_category_id" name="product_category_id" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $pc)
                                    <optgroup label="{{$pc->name}}">
                                        @foreach($pc->children as $childCategory)
                                        <option value="{{$childCategory->id}}" {!! fselectvalue($childCategory->id, $data, 'product_category_id') !!}>{{$childCategory->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {!! ffile('safety_file', 'Security Document (pdf file)', $data, 'application/pdf') !!}

                        {!! ffile('technical_information_file', 'Technical Information (pdf file)', $data, 'application/pdf') !!}

                    </div>
                    <div class="col-md-8">

                        {!! ftextarea('description', 'Description', fvalue($data, 'description'), '', true) !!}

                        <div class="input">
                            <label>Technical description</label>
                        </div>
                        <div class="technical-description">
                            <div class="tech-description-lines"></div>
                            <p class="add-helper">Click the plus below to add a line.</p>
                            <div class="add-line">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                    	<g id="add-circle">
                                    		<path class="add-circle-green" d="M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M382.5,280.5h-102v102h-51v-102    h-102v-51h102v-102h51v102h102V280.5z" fill="#FFFFFF"/>
                                    	</g>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <div class="input">
                            <label>Product Images</label>
                            <span class="input__description" style="max-width: 100%;">Click to select the main image, right click an image to delete it.</span>
                        </div>
                        <div class="product-images">
                            <div class="images"></div>
                            <p class="add-helper">Click the plus below to add an image.</p>
                            <input type="file" multiple name="imageUpload" accept="image/jpg" style="display: none;" data-url="{{ route('products.images', $data->id) }}">
                            <div class="add-image">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                    	<g id="add-circle">
                                    		<path class="add-circle-green" d="M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M382.5,280.5h-102v102h-51v-102    h-102v-51h102v-102h51v102h102V280.5z" fill="#FFFFFF"/>
                                    	</g>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        {!! ffile('product_sizes', 'Product Sizes (csv file)', $data, 'text/csv') !!}

                        @if($productSizeCount > 0)
                        <a href="{{route('products.sizes.delete', $data->id)}}" class="delete">{{$productSizeCount}} sizes registered - click here to remove all</a>
                        @endif

                    </div>
                    <div class="col-md-1"></div>
                </div>

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('products')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>

@if(isset($techInfo))
<script> window.technicalInformation = '{!!json_encode($techInfo)!!}'; </script>
@endif

@if(isset($images))
<script> window.productImages = '{!!json_encode($images)!!}'; </script>
@endif

<div class="product-images-upload">
    <div class="upload-status">
        <h3>Uploading image/s</h3>
        <img src="{{asset('uploading.svg')}}" height="40" alt="Uploading">
    </div>
</div>
@endsection
