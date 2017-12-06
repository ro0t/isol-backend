<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

    }

    public function uploadPhoto(Request $request) {

        if( $request->hasFile('trumbowyg_image') ) {

            $image = $request->file('trumbowyg_image');
            $ext = $image->extension();
            $fileName = md5($image->path() . time() . mt_rand()) . '.' . $ext;
            $image->storeAs('article-images', $fileName);
            $url = asset('/article-images/' . $fileName);

            return response()->json([
                'file' => $url,
                'extension' => $ext,
                'success' => true
            ]);

        }

        return response()->json([
            'error' => 'Could not save uploaded file, please try again.',
            'code' => 500
        ], 500);

    }

}
