<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

define('PAGE_SIZE', 24);

class Product extends Model {

    protected $table = 'product';
    protected $guarded = ['id'];

    protected function products( $request ) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $category = $request->has('category') ? $request->get('category') : null;
        $manufacturer = $request->has('manufacturer') ? $request->get('manufacturer') : null;
        $searchQuery = $request->has('q') ? $request->get('q') : null;

        if( $searchQuery ) {
            return $this->search($searchQuery);
        }

        $products = self::select('product.id', 'product_images.image', 'product.slug', 'product.name', 'manufacturer.name as manufacturer', 'manufacturer.slug as manslug')
                        ->where('product.active', 1)
                        ->join('manufacturer', 'product.manufacturer_id', '=', 'manufacturer.id')
                        ->join('product_images', function($query) {
                            $query->on('product.id', '=', 'product_images.product_id')->where('main_image', 1);
                        })
                        ->limit(PAGE_SIZE, $page);

        if( $category ) {

            $products->where('product_category_id', function($query) use($category) {
                $query->select('id')->from(with(new ProductCategory)->getTable())->where('slug', $category);
            });

        }

        if( $manufacturer ) {

            $products->where('manufacturer_id', function($query) use($manufacturer) {
                $query->select('id')->from(with(new Manufacturer)->getTable())->where('slug', $manufacturer);
            });

        }

        $products = $products->get();

        $products = $products->map(function($product) {

            if( $product->image != null ) {
                $product->image = url($product->image);
            }

            return $product;

        });

        return $products;

    }

    private function search( $q ) {

        if( strlen($q) < 3 ) {
            return [];
        }

        $products = self::select('product.id', 'product.navision_id', 'product.slug', 'product.name', 'manufacturer.slug as manslug')
            ->join('manufacturer', 'product.manufacturer_id', '=', 'manufacturer.id')
            ->where('product.active', 1)
            ->where(function($query) use($q) {
                $query->where('product.name', 'LIKE', '%' . $q . '%')
                    ->orWhere('product.navision_id', 'LIKE', '%' . $q . '%');
            })
            ->limit(5)
            ->get();


        return $products;

    }

    protected function hideValues($product) {

        unset($product->active);
        unset($product->created_at);
        unset($product->updated_at);

    }

    protected function single($request, $id) {

        // Return single product + related related products
        $product = self::where('slug', $id)
            ->with('manufacturer')
            ->first();

        if( !$product ) \App::abort(404);

        if( $product->safety_file != null ) {
            $product->safety_file = url($product->safety_file);
        }

        if( $product->technical_information_file != null ) {
            $product->technical_information_file = url($product->technical_information_file);
        }

        $images = ProductImages::getImagesFor($product->id, true);
        $techInfo = ProductInformation::getInformationFor($product->id);

        $images = $images->map(function($image) {

            $image->image = url($image->image);
            return $image;

        });

        $product->images = $images;
        $product->technical_information = $techInfo;

        // Clean up the JSON
        $this->hideValues($product);
        $product->relatedProducts = $this->getRelated($product);

        return $product;

    }

    public function getRelated( Product $originalProduct ) {

        $related = [];

        $categoryId = $originalProduct->product_category_id;

        $related = DB::select(DB::raw("SELECT a.id, a.slug, a.name, d.name as manufacturer, d.slug as manslug, c.image FROM product a " .
                "INNER JOIN (".
                	"SELECT manufacturer_id, COUNT(*) totalCount FROM product WHERE product_category_id = {$categoryId} AND active = 1 GROUP BY manufacturer_id " .
                ") b ON a.manufacturer_id = b.manufacturer_id " .
                "INNER JOIN product_images c ON c.product_id = a.id " .
                "INNER JOIN manufacturer d ON a.manufacturer_id = d.id " .
                "WHERE a.product_category_id = {$categoryId} " .
                "AND a.active = 1 " .
                "AND c.main_image = 1 " .
                "ORDER BY b.totalCount DESC, a.id ASC LIMIT 3"));

        if( count($related) > 0 ) {
            foreach($related as $product) {
                if( $product->image != null ) {
                    $product->image = url($product->image);
                }
            }
        }

        return $related;

    }

    public function manufacturer() {
        return $this->belongsTo('App\Models\Manufacturer', 'manufacturer_id');
    }

}
