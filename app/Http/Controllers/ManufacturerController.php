<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManufacturerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->breadcrumbs('Manufacturers');

        return view('modules.manufacturers.list');
    }
}
