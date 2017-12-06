@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="frontpage-container" init="true">
        <div class="frontpage">
            <ul class="frontpage-sortable">
                <li class="tile smaller">
                    <span class="frontpage-module-type">Manufacturer</span>
                    <p class="frontpage-module-data">Facom</p>
                </li>
                <li class="tile large">
                    <span class="frontpage-module-type">Manufacturer</span>
                    <p class="frontpage-module-data">Festool</p>
                </li>
            </ul>
            <hr>
            <ul class="frontpage-sortable">
                <li class="tile large">
                    <span class="frontpage-module-type">Manufacturer</span>
                    <p class="frontpage-module-data">Spit</p>
                </li>
                <li class="tile smaller">
                    <span class="frontpage-module-type">Articles</span>
                    <p class="frontpage-module-data">Latest posts</p>
                </li>
            </ul>
        </div>

        <div class="frontpage-type-editor">
            <div class="underlay"></div>
            <div class="type-settings">
                <label class="select--label" for="type">Frontpage module type</label>
                <div class="select">
                    <select name="type" name="type">
                        <option value="MANUFACTURER">Manufacturer</option>
                        <option value="SLIDESHOW">Slideshow</option>
                        <option value="ARTICLES">Articles</option>
                    </select>
                </div>
                <label class="select--label" for="type">Frontpage module datasource</label>
                <div class="select">
                    <select name="datalist">
                        <option value="festool">Festool</option>
                        <option value="facom">Facom</option>
                        <option value="spit">Spit</option>
                    </select>
                </div>
                <div class="type-actions">
                    <div class="save">Update</div>
                    <div class="cancel">Cancel</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
