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

    public function sitemap() {

      $response = Product::sitemap();
      return $this->json($response);

    }

}
