<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class ResponseController extends BaseController {

    public function __construct(Request $request) {

        // Check if Request is valid.

    }

    public function json( $data, $status = 200 ) {

        $response = new Response( json_encode($data), $status );

        $response->header('Content-Type', 'application/json');
        $response->header('Access-Control-Allow-Origin', '*');

        return $response;

    }

}
