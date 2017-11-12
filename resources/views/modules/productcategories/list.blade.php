@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-24">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Page</td>
                        <td>Url</td>
                        <td></td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 10; $i++)
                    <tr>
                        <td>Forsíða</td>
                        <td>/</td>
                        <td></td>
                        <td>Edit</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
