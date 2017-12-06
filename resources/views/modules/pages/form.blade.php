@extends('layouts.app')

@section('head')
<script src="{{asset('vendor/trumbowyg/trumbowyg.min.js')}}"></script>
<script src="{{asset('vendor/trumbowyg/plugins/upload/trumbowyg.upload.js')}}"></script>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form method="post">
                {{ csrf_field() }}

                {!! ftextarea('content', 'Content', $pageContent) !!}

                <label class="select--label" for="show_extra_widgets">Show settings below content? Opening hours, location and about the company?</label>
                <div class="select">
                    <select name="show_extra_widgets" id="show_extra_widgets">
                        <option value="1" {!! $page->show_extra_widgets ? 'selected' : '' !!}>Yes</option>
                        <option value="0" {!! !$page->show_extra_widgets ? 'selected' : '' !!}>No</option>
                    </select>
                </div>

                <div class="input">
                    <label>Page Images</label>
                    <span class="input__description" style="max-width: 100%;">Right click an image to remove the image.</span>
                </div>
                <div class="product-images">
                    <div class="images"></div>
                    <p class="add-helper">Click the plus below to add an image.</p>
                    <input type="file" multiple name="imageUpload" accept="image/jpg" style="display: none;" data-url="{{ route('page.images', $page->id) }}">
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

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('home')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>

@if(isset($images))
<script> window.pageImages = '{!!json_encode($images)!!}'; </script>
@endif

<div class="product-images-upload">
    <div class="upload-status">
        <h3>Uploading image/s</h3>
        <img src="{{asset('uploading.svg')}}" height="40" alt="Uploading">
    </div>
</div>
@endsection
