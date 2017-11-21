<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {

        View::share('breadcrumbs', '');

    }


    public function breadcrumbs() {

        $args = func_get_args();

        if( count($args) > 1 ) {
            return View::share('breadcrumbs', implode($args, '<span></span>'));
        }

        View::share('breadcrumbs', $args[0]);

    }

    public function success($message, $code = 200) {

        return response()->json([
            'message' => $message
        ], $code);

    }

    public function error($error, $code = 400) {

        return response()->json([
            'message' => $error
        ], $code);

    }

}
