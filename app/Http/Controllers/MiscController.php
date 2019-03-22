<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Page;

class MiscController extends BaseController
{

    public function generateSitemap()
    {

        $products = Product::sitemap();
        $categories = ProductCategory::getParentsAndChildren(0);
        $pages = Page::select('url')->where('url', '!=', '/')->get();

        $sitemap = view('sitemap-template')
            ->with('subpages', $pages)
            ->with('categories', $categories)
            ->with('products', $products);

        return response($sitemap)
            ->header('Content-Type', 'text/xml;charset=utf-8');

    }

}
