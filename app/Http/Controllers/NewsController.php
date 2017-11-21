<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller {

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

        $this->breadcrumbs('News');

        //$pages = Page::all();

        return view('modules.news.list');
            //->with('data', $pages) ;
    }

    public function create() {

    }

    public function edit($id) {

    }

    public function createNew() {

    }

    public function change(Request $request, $id) {



    }


}
