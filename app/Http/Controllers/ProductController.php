<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IGW\IsolProductList;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\ProductImages;
use App\Models\ProductInformation;
use App\Models\ProductCategory;
use App\Models\Manufacturer;

class ProductController extends Controller {

    private $categories;
    private $manufacturers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

        $this->categories = ProductCategory::getWebsiteItems();
        $this->manufacturers = Manufacturer::getActive();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->breadcrumbs('Products');

        return view('modules.products.list');
    }

    public function create() {

        $this->breadcrumbs('Products', 'Create');

        return view('modules.products.form')
            ->with('manufacturers', $this->manufacturers)
            ->with('categories', $this->categories)
            ->with('data', null);

    }

    public function edit($id) {

        $product = Product::find($id);

        if(!$product) \App::abort(404);

        $this->breadcrumbs('Products', $product->name, 'Edit');

        $images = ProductImages::getImagesFor($product->id);
        $technical = ProductInformation::getInformationFor($product->id);

        return view('modules.products.form')
            ->with('data', $product)
            ->with('images', $images)
            ->with('technical', $technical);

    }

    public function navision(Request $request) {

        $lines = ProductLine::findQuery($request->get('q'));

        return response()->json($lines);

    }

    public function delete($id) {



    }

    public function createNew(Request $request) {

        return redirect()->route('products.new')->withInput()->with('error', 'Product was not created!!!!!!!!!!!');

    }

    public function change(Request $request, $id) {



    }

    public function setWebsiteVisibility(Request $request, $id) {



    }

}
