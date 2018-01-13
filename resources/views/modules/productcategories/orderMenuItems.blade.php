@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="ordermenuitems-container" init="true">

        <p align="center" style="text-align: center; margin-bottom: 25px;">Click and drag items to order</p>

        <ul class="sortable-styled sortable">
            @foreach($menuItems as $category)

            <li id="category_{{$category->id}}">
                <p>{{$category->name}}</p>
            </li>
            @endforeach
        </ul>

    </div>

</div>
@endsection
