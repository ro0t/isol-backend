<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageSEO;

class SearchEngineOptimization extends ResponseController
{

    public function __construct(Request $request)
    {

        // Check if Request is valid.

    }

    public function metaData(Request $request, $segment)
    {

        if ($segment == 'index') $segment = '/';

        $page = Page::where('url', $segment)->first();

        if ($page) {

            if ($segment == '/') $segment = 'index';

            // Get Page SEO
            $pageSeo = PageSEO::where('page_id', $page->id)->first();

            if (isset($pageSeo->og_title)) {
                return $this->json([
                    'seo' => [
                        'id' => $segment,
                        'title' => $pageSeo->og_title,
                        'description' => $pageSeo->og_description,
                        'type' => $pageSeo->og_type,
                        'keywords' => $pageSeo->keywords
                    ]
                ]);
            }

        }

        return $this->json([
            'seo' => [
                'id' => $segment,
                'title' => 'Ísól',
                'description' => 'Ísól er fjölskyldufyrirtæki sem hefur þjónustað iðnað á Íslandi frá árinu 1959, meginstarfsemi fyrirtækisins er heildsala á verkfærum, festingum og efnavöru á fyrirtækjamarkaði.',
                'type' => 'website',
            ]
        ]);

    }

}
