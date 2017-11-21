@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('manufacturers.new', 'New manufacturer') !!}
        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Manufacturer</td>
                        <td>Image</td>
                        <td align="center">Show on website?</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $manufacturer)
                    <tr>
                        <td>{{$manufacturer->name}}</td>
                        <td><img src="{{asset($manufacturer->image)}}" width="70" alt="{{$manufacturer->name}} image"></td>
                        <td align="center">
                            <label class="switch">
                                <input type="checkbox" data-url="{{route('manufacturers.setActive', $manufacturer->id)}}" {!! isChecked($manufacturer->active) !!}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td align="right">
                            <a href="{{route('manufacturers.edit', $manufacturer->id)}}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
