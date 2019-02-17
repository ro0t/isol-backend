<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller {

    private $model;

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
    public function index($id = 0) {

        $this->breadcrumbs('Products', 'Categories');

        if( $id > 0 ) {
            $pc = ProductCategory::find($id);

            if( !$pc || !$pc->active ) {
                return \App::abort(404);
            }

            $this->breadcrumbs('Products', 'Categories', $pc->name);
        }

        $data = ProductCategory::getParentsAndChildren($id);

        return view('modules.productcategories.list')
            ->with('depthId', $id)
            ->with('data', $data);
    }

    public function indexWithDepth($categoryId) {
        return self::index($categoryId);
    }

    public function create() {
        $this->breadcrumbs('Products', 'Categories', 'Create');
        $parents = ProductCategory::getParentsAndChildren(0);

        return view('modules.productcategories.form')
            ->with('parents', $parents)
            ->with('data', null);
    }

    public function orderMenuItems($id = 0) {
        $this->breadcrumbs('Products', 'Categories', 'Order menu categories');
        $menuItems = ProductCategory::getChildren($id);

        return view('modules.productcategories.orderMenuItems')
            ->with('menuItems', $menuItems);

    }

    public function edit($id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            $this->breadcrumbs('Products', 'Categories', $pc->name);
            $parents = ProductCategory::getParentsAndChildren(0);

            return view('modules.productcategories.form')
                ->with('parents', $parents)
                ->with('data', $pc);

        }

        \App::abort(404);

    }

    public function delete($id) {

        $pc = ProductCategory::find($id);

        if( $pc != null ) {
            $pc->active = 0;
            $pc->save();

            return redirect()
                ->route('categories')
                ->with('success', 'Product category ' . $pc->name . ' has been deleted!');
        }

        return redirect()
            ->route('categories')
            ->with('error', 'Could not find product category with this id');

    }

    public function change(Request $request, $id) {

        $pc = ProductCategory::find($id);

        if($pc != null) {

            if( $request->hasFile('image') ) {

                $extension = $request->image->extension();
                $fileName = 'm-' . md5($request->image->path()) . '.' . (($extension == 'jpeg' || $extension == 'jpg') ? 'jpg' : 'png');
                $request->image->storeAs('product-images', $fileName);
                $pc->image = '/product-images/' . $fileName;

            }

            $pc->name = $request->get('name');
            $pc->slug = str_slug($request->get('name'));

            $newParent = $request->get('parent');

            // Cannot set itself to parent.
            if($newParent != $id) {
                $pc->parent = $request->get('parent');
            }

            $pc->save();

            return redirect()
                ->route('categories')
                ->with('success', 'Product category ' . $pc->name . ' has been saved!');

        }

        \App::abort(500);

    }

    public function orderMenuItemsPost(Request $request) {
        if( $request->has('category') ) {
            $category = $request->get('category');

            if( is_array($category) ) {
                $i = 0;

                foreach($category as $categoryId) {
                    $productCategory = ProductCategory::where('id', $categoryId)->update([
                        'order' => $i++
                    ]);
                }

                return response()->json([
                    'message' => 'Category order has been saved.'
                ]);
            }
        }
        \App::abort(500);
    }

    public function createNew(Request $request) {

        if( !$request->has('name') || empty($request->get('name')) ) {
            return redirect()->route('categories.new')->with('error', 'You have to enter a name for this product category.');
        }

        if( $request->hasFile('image') ) {

            $extension = $request->image->extension();
            $fileName = 'm-' . md5($request->image->path()) . '.' . (($extension == 'jpeg' || $extension == 'jpg') ? 'jpg' : 'png');
            $request->image->storeAs('product-images', $fileName);
            $image = '/product-images/' . $fileName;

        }

        $pc = ProductCategory::create([
            'name' => $request->get('name'),
            'slug' => str_slug($request->get('name')),
            'parent' => $request->get('parent'),
            'show_menu' => 0,
            'image' => (isset($image)) ? $image : null,
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
