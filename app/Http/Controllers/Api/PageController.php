<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\Settings;

class PageController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function getContent(Request $request, $slug) {

        $page = Page::where('url', $slug)->first();

        if( $page != null ) {

            $pc = PageContent::where('page_id', $page->id)->first();

            $pageObject = [
                'id' => $slug,
                'title' => $page->name,
                'html' => trim(stripslashes($pc->content))
            ];

            return $this->json([
                'page' => $pageObject
            ]);

        }

        return $this->json([ 'message' => 'Page not found' ], 404);

    }

    protected function getContentWidgets() {

        $oh             = Settings::getContent('opening-hours');
        $footer         = Settings::getContent('footer');
        $en             = Settings::getContent('emergency-number');

        return $this->json([
            'widgets' => [
                'id' => 'WIDGETS',
                'openingHours'             => $oh,
                'footer'                    => $footer,
                'emergencyNumber'          => $en
            ]
        ]);

    }

}
