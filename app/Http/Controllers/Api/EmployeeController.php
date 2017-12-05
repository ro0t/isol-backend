<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function list(Request $request) {

        $employees = Employee::getActive();

        $employees = $employees->map(function($item) {

            $item->image = asset($item->image);
            return $item;

        });

        return $this->json([
            'employees' => $employees
        ]);

    }

}
