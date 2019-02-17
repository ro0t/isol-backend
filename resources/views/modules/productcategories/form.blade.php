@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                {!! finput('name', 'Name', fvalue($data, 'name')) !!}

                <label class="select--label" for="parent">Parent category</label>
                <div class="select">
                    <select id="parent" name="parent">
                        <option value="0">No parent category</option>
                        @foreach($parents as $parent)
                            <option value="{{$parent->id}}" {!! fselectvalue($parent->id, $data, 'parent') !!}>{{$parent->name}}</option>
                            @if($parent->childCount > 0)
                                <optgroup label="Children of {{$parent->name}}">
                                    @foreach($parent->children as $child)
                                        <option value="{{$child->id}}" {!! fselectvalue($child->id, $data, 'parent') !!}>{{$child->name}}</option>
                                    @endforeach
                                </optgroup>
                                <option value="" disabled> </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {!! fimage('image', 'Category Image (w:430 h:280)', fvalue($data, 'image')) !!}

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('categories')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
