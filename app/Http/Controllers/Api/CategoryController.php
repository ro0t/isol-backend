<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class CategoryController extends ResponseController {

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

        if( $request->has('parent') ) {
            $categories = ProductCategory::getChildren($request->get('parent'));

            if( count($categories) == 0 ) {
                return response()->json(['message' => 'No children'], 404);
            }
        }

        return $this->json([ 'categories' => $categories ]);
    }

}
