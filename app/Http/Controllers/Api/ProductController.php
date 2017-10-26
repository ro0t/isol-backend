<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function categories() {

        return $this->json([
            'products' => [
                [
                    'id' => 1,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Handverkfæri'
                    ]
                ],
                [
                    'id' => 2,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Rafmagnsverkfæri'
                    ]
                ],
                [
                    'id' => 3,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Festingar'
                    ]
                ],
                [
                    'id' => 4,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Kítti og efnavörur'
                    ]
                ],
                [
                    'id' => 5,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Mælitæki'
                    ]
                ],
                [
                    'id' => 6,
                    'type' => 'category',
                    'attributes' => [
                        'name' => 'Aukahlutir'
                    ]
                ]
            ]
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
