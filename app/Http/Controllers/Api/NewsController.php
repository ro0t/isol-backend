<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends ResponseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    protected function latestNews(Request $request) {

        $news = News::select('id', 'slug', 'title', 'content', 'image', 'created_at')
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        $news = $news->map(function($item, $key) {

            if($item->image != null)
                $item->image = asset($item->image);

            return $item;

        });

        if( $news ) {
            return $this->json([ 'news' => $news ]);
        }

        return $this->json([ 'message' => 'Could not find any news' ], 404);

    }

    protected function allNews(Request $request) {

        $all = News::select('id', 'slug', 'title', 'content', 'image', 'created_at')->where('active', 1)->orderBy('id', 'desc')->get();

        $all = $all->map(function($item, $key) {

            if( $item->image != null)
                $item->image = asset($item->image);

            return $item;

        });

        if( $all ) {
            return $this->json([ 'news' => $all ]);
        }

        return $this->json([ 'message' => 'Could not find any news' ], 404);

    }

    protected function detail(Request $request, $id) {

        $detail = News::select('id', 'slug', 'title', 'content', 'image', 'created_at')->where('slug', $id)->where('active', 1)->first();

        if($detail) {

            if( $detail->image != null ) {
                $detail->image = asset($detail->image);
            }

            return $this->json([ 'news' => $detail ]);
        }

        return $this->json([ 'message' => 'Could not find requested news' ], 404);

    }

}
