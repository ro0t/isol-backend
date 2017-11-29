@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <form method="post">
                {{ csrf_field() }}

                {!! finput('name', 'Name', fvalue($data, 'name')) !!}

                <label class="select--label" for="parent">Parent category</label>
                <div class="select">
                    <select id="parent" name="parent">
                        <option value="">No parent category</option>
                        @foreach($parents as $parent)
                        <option value="{{$parent->id}}" {!! fselectvalue($parent->id, $data, 'parent') !!}>{{$parent->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('categories')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
