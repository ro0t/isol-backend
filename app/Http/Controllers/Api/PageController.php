<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Frontpage;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageImages;
use App\Models\Settings;
use App\Models\ProductCategory;

class PageController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function frontpage( Request $request ) {

        if( !$request->has('row') ) return \App::abort(404);

        $rowId = $request->get('row');

        $fp = Frontpage::select('id', 'data','size','type')->where('row_id', $rowId)->orderBy('row_placement', 'ASC')->get();

        if( count($fp) > 0 ) {

            foreach($fp as $fpItem) {
                $fpItem->tile = $fpItem->getDataFor( $fpItem->type, json_decode($fpItem->data) );
            }

            return $this->json([
                'frontpages' => $fp
            ]);

        }

        return \App::abort(404);

    }

    protected function getContent(Request $request, $slug) {

        $page = Page::where('url', $slug)->first();

        if( $page != null ) {

            $pc = PageContent::where('page_id', $page->id)->first();
            $images = PageImages::getImagesFor($page->id);

            $pageObject = [
                'id' => $slug,
                'title' => $page->name,
                'show_extra_widgets' => $page->show_extra_widgets,
                'html' => trim(stripslashes($pc->content)),
                'images' => $images
            ];

            return $this->json([ 'page' => $pageObject ]);

        }

        return $this->json([ 'message' => 'Page not found' ], 404);

    }

    protected function getContentWidgets() {

        $menu           = ProductCategory::getParentsAndChildren(0);
        $oh             = Settings::getContent('opening-hours');
        $footer         = Settings::getContent('footer');
        $en             = Settings::getContent('emergency-number');

        return $this->json([
            'menu' => $menu,
            'widgets' => [
                'id' => 'WIDGETS',
                'openingHours'             => $oh,
                'footer'                   => $footer,
                'emergencyNumber'          => $en
            ]
        ]);

    }

}
