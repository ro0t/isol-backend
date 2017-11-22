@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {!! ferrors() !!}
        <div class="col-md-4">
            <form method="post" autocomplete="off">
                {{ csrf_field() }}

                {{-- DISABLE CHROME AUTOFILL --}}
                <input tabindex="-1" style="opacity: 0; height: 1; width: 0; pointer-events: none; position: absolute; top: -250px; right: -500px;" type="email" name="disableemailfill"/>
                <input tabindex="-1" style="opacity: 0; height: 1; width: 0; pointer-events: none; position: absolute; top: -250px; right: -500px;" type="password" name="disablepasswordfill"/>

                {!! finput('name', 'Name', fvalue($data, 'name'), '', true) !!}
                {!! finput('email', 'E-mail', fvalue($data, 'email'), 'The user will log in with this e-mail address.', true, 'email') !!}
                {!! finput('password', 'Password', '', 'Only fill this out if you want to change the users password.', (isset($data['email']) ? false : true), 'password') !!}

                <label class="select--label" for="level">User type</label>
                <div class="select">
                    <select id="level" name="level">
                        <option value="0" {!! fselectvalue(0, $data, 'super_admin') !!}>Administrator</option>
                        <option value="1" {!! fselectvalue(1, $data, 'super_admin') !!}>Super administrator</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{{route('users')}}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
