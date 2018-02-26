<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Page;

class MiscController extends BaseController {

  public function generateSitemap() {

    $products = Product::sitemap();
    $pages = Page::select('url')->where('url', '!=', '/')->get();

    $sitemap = view('sitemap-template')
      ->with('subpages', $pages)
      ->with('products', $products);

    return response($sitemap)->header('Content-Type', 'text/xml;charset=utf-8');

  }

}
