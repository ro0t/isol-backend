<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frontpage;

class FrontpageController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

    }

    public function editFrontpage() {

        $this->breadcrumbs('Pages', 'Frontpage');

        $fp = new Frontpage();

        return view('modules.frontpage.editor')
            ->with('types', $fp->getTypes())
            ->with('firstRow', $fp->getRowItems(1))
            ->with('secondRow', $fp->getRowItems(2));

    }

    public function updateModule(Request $request, $moduleId) {

        $fp = Frontpage::where('id', $moduleId)->first();

        if( !$fp ) return \App::abort(404);

        $fp->type = $request->get('type');
        $fp->data = $request->get('data');

        if( $fp->save() ) {

            return response()->json([
                'type' => $fp->type,
                'moduleTitle' => $fp->getTitle(),
                'message' => 'Module has been updates successfully.'
            ]);

        }

        return \App::abort(500);

    }

    public function updateModulePositions(Request $request, $rowId) {

        if( $request->has('tile') ) {

            $tile = $request->get('tile');

            if( is_array($tile) ) {

                $i = 0;

                foreach($tile as $tileId) {

                    $tile = Frontpage::where('id', $tileId)->where('row_id', $rowId)->update([
                        'row_placement' => $i++
                    ]);

                }

                return response()->json([
                    'message' => 'Tile positions updated.'
                ]);

            }

        }

        return \App::abort(500);

    }

    /**
    *   Frontpage slideshow
    *   - Upload one or more files and display it in a special lightbox object on the website
    */
    public function addImages(Request $request) {

        if( $request->hasFile('images') ) {

            $count = 0;
            $images= [];

            foreach( $request->images as $image ) {

                $ext = $image->extension();
                $fileName = md5( 'frontpage-' . $image->path() . time() ) . '.' . ($ext == 'jpeg' ? 'jpg' : $ext);
                $image->storeAs('article-images', $fileName);

                $path = '/article-images/' . $fileName;

                $images[] = [ 'image' => asset($path) ];
                $count++;

            }

            return response()->json(['message' => $count . ' images uploaded successfully', 'images' => $images], 200);

        }

    }

}
