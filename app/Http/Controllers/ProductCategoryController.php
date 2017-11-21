<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller {

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

        $this->breadcrumbs('Products', 'Categories');

        $data = ProductCategory::getList();

        return view('modules.productcategories.list')
            ->with('data', $data);
    }

    public function create() {

        $this->breadcrumbs('Products', 'Categories', 'Create');

        return view('modules.productcategories.form')
            ->with('data', null);

    }

    public function edit($id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            $this->breadcrumbs('Products', 'Categories', $pc->name);

            return view('modules.productcategories.form')
                ->with('data', $pc);

        }

        \App::abort(404);

    }

    public function delete($id) {

        $pc = ProductCategory::find($id);

        if( $pc != null ) {

            $pc->active = 0;
            $pc->save();

            return redirect()->route('categories')->with('success', 'Product category ' . $pc->name . ' has been deleted!');

        }

        return redirect()->route('categories')->with('error', 'Could not find product category with this id');

    }

    public function change(Request $request, $id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            $pc->name = $request->get('name');
            $pc->slug = str_slug($request->get('name'));
            $pc->save();

            return redirect()->route('categories')->with('success', 'Product category ' . $pc->name . ' has been saved!');

        }

        \App::abort(500);

    }

    public function createNew(Request $request) {

        if( !$request->has('name') || empty($request->get('name')) ) {
            return redirect()->route('categories.new')->with('error', 'You have to enter a name for this product category.');
        }

        $pc = ProductCategory::create([
            'name' => $request->get('name'),
            'slug' => str_slug($request->get('name'))
        ]);

        if( $pc ) {
            return redirect()->route('categories')->with('success', 'New product category has been created.');
        }

        return redirect()->route('categories.new')->withInput()->with('error', 'Something went wrong with creating a product category, please try again.');

    }

    public function setWebsiteVisibility(Request $request, $id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            $pc->show_website = $request->get('checked');
            $pc->save();

            return $this->success('Product category updated successfully');

        }

        return $this->error('Could not find product category with id ' . $id);

    }

    public function setMenuVisibility(Request $request, $id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            $pc->show_menu = $request->get('checked');
            $pc->save();

            return $this->success('Product category updated successfully');

        }

        return $this->error('Could not find product category with id ' . $id);

    }
}
