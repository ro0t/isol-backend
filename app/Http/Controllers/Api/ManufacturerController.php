<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Manufacturer;

class ManufacturerController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function list() {

        $manufacturers = Manufacturer::getActive();

        $manufacturers = $manufacturers->map(function($item, $key) {

            $item->image = asset($item->image);
            return $item;

        });

        return $this->json([
            'manufacturers' => $manufacturers
        ]);

    }

}
