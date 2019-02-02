@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-24" id="igw-table-actions">
                <div class="left-side">

                    <div class="igw-table-action">
                        <a href="{{route('products')}}" class="btn btn-create btn-toggle">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-24">
                <div id="productSync" class="in-sync">
                    <div>
                        <h3>Sync products</h3>
                        <p>This process might take a long time, this may cause heavy load on the system while it's running, run this process when there is not much traffic on the website (usually during late hours..).</p>

                        <button id="sync-button" class="btn btn-primary">Start syncing</button>
                        <div id="sync-progress">
                            <div class="loader"></div> The products are being synced, this may take a while...
                        </div>
                        <h4 id="sync-finished">Sync completed, prices have been updated.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
