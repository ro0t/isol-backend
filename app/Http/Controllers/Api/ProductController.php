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

    protected function list(Request $request) {

        $response = Product::products($request, 'model_number', true);

        return $this->json([
            'products' => $response->products,
            'meta' => $response->metas
        ]);

    }

    public function detail(Request $request, $id) {

        return $this->json([
            'product' => Product::single($request, $id)
        ]);

    }

}
