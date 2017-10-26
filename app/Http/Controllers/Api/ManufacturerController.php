<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;

class ManufacturerController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function list() {

        return $this->json([
            'data' => [
                [
                    'id' => 1,
                    'type' => 'manufacturer',
                    'attributes' => [
                        'slug' => 'festool',
                        'name' => 'Festool'
                    ]
                ],
                [
                    'id' => 2,
                    'type' => 'manufacturer',
                    'attributes' => [
                        'slug' => 'facom',
                        'name' => 'Facom'
                    ]
                ],
                [
                    'id' => 3,
                    'type' => 'manufacturer',
                    'attributes' => [
                        'slug' => 'dl-chemicals',
                        'name' => 'DL Chemicals'
                    ]
                ],
                [
                    'id' => 4,
                    'type' => 'manufacturer',
                    'attributes' => [
                        'slug' => 'spit',
                        'name' => 'Spit'
                    ]
                ]
            ]
        ]);

    }

}
