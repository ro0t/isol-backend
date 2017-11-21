<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function categories(Request $request) {

        $categories = null;

        if( $request->has('show') && $request->get('show') == 'menu' ) {
            $categories = ProductCategory::getMenuItems();
        }

        if( $request->has('show') && $request->get('show') == 'website' ) {
            $categories = ProductCategory::getWebsiteItems();
        }

        return $this->json([
            'categories' => $categories
        ]);
    }

    protected function list() {

        $prod = new Product();

        return $this->json([
            'products' => $prod->all()
        ]);

    }

    public function detail($id) {

        $prod = new Product();

        return $this->json([
            'product' => $prod->all($id)
        ]);

    }

}
