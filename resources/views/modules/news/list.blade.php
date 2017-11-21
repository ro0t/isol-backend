@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24" id="igw-table-actions">
            {!! fcreate('news.new', 'Write post') !!}
        </div>
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Url</td>
                        <td>Image</td>
                        <td>Show on website?</td>
                        <td align="right">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right">Edit</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
