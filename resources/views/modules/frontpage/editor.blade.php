@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="frontpage-container" init="true">
        <div class="frontpage">
            @if($firstRow)
            <ul class="frontpage-sortable" data-row-id="1">
                @foreach($firstRow as $tile)
                <li class="tile {{$tile->size}}" id="tile_{{$tile->id}}" data-id="{{$tile->id}}" data-tile="{{ $tile->data }}" data-type="{{$tile->type}}">
                    <span class="frontpage-module-type">{{$types[$tile->type]}}</span>
                    <p class="frontpage-module-data">{{$tile->moduleTitle}}</p>
                </li>
                @endforeach
            </ul>
            @endif
            @if($secondRow)
            <hr>
            <ul class="frontpage-sortable" data-row-id="2">
                @foreach($secondRow as $tile)
                <li class="tile {{$tile->size}}" id="tile_{{$tile->id}}" data-id="{{$tile->id}}" data-tile="{{ $tile->data }}" data-type="{{$tile->type}}">
                    <span class="frontpage-module-type">{{$types[$tile->type]}}</span>
                    <p class="frontpage-module-data">{{$tile->moduleTitle}}</p>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <div class="frontpage-type-editor">
            <div class="underlay"></div>
            <div class="type-settings">
                <label class="select--label" for="type">Frontpage module type</label>
                <div class="select">
                    <select name="type" name="type">
                        @foreach($types as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="module-options"></div>
                <div class="type-actions">
                    <div class="save">Update</div>
                    <div class="cancel">Cancel</div>
                </div>
            </div>
        </div>

        <input type="file" multiple id="frontpage-slideshow" accept="image/jpg,image/png" style="display: none;" data-url="{{ route('frontpage.slideshow.upload') }}">

    </div>
</div>
@endsection
