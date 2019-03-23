<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

define('PAGE_SIZE', 350);

class Product extends Model {
    protected $table = 'product';
    protected $guarded = ['id'];

    private $metas = [];
    private $manufacturerMetas = [];

    private $productCategory = null;
    private $childCategories = [];

    private function categories( Request $request ) {

        if( $request->has('category') ) {

            $slug = $request->get('category');

            if( $slug === 'vorur' ) {
                return ($this->childCategories = ProductCategory::getParents('order'));
            }

            $this->productCategory = ProductCategory::where('slug', $slug)->pluck('id');

            if($this->productCategory) {
                $this->childCategories = ProductCategory::getChildren($this->productCategory);
            }
        }

    }

    protected function featuredProducts() {

        $products = self::select('product.id', 'product.slug', 'product.name', 'product_images.image', 'product.manufacturer_id', 'manufacturer.name as manufacturer')
            ->where('product.featured', 1)
            ->where('product.active', 1)
            ->inRandomOrder();

        $products->join('manufacturer', 'product.manufacturer_id', '=', 'manufacturer.id')
            ->leftJoin('product_images', function($query) {
                $query->on('product.id', '=', 'product_images.product_id')->where('main_image', 1);
            })
            ->limit(4);

        $products = $products->get();

        $products = $products->map(function($product) {

            // URLify the image so we can display it on the requesting website.
            if ($product->image != null) {
                $product->image = url($product->image);
            }

            return $product;
        });

        return $products;

    }

    protected function products( Request $request, $sortBy = false, $includeMetas = false ) {

        $response = new \stdClass();
        $response->categories = [];
        $response->products = [];
        $response->metas = [];

        // Initialize category data
        $this->categories($request);

        if( count($this->childCategories) > 0 ) {
            $response->categories = $this->childCategories;
            return $response;
        }

        $page = $request->has('page') ? $request->get('page') : 1;
        $manufacturer = $request->has('manufacturer') ? $request->get('manufacturer') : null;
        $searchQuery = $request->has('q') ? $request->get('q') : null;

        $products = self::select('product.id', 'product.model_number', 'product_images.image', 'product.slug', 'product.name', 'manufacturer.name as manufacturer', 'manufacturer.slug as manslug', 'manufacturer.id as manid', 'manufacturer.image as manimg')
                        ->where('product.active', 1);

        $products = $products->orderBy('id', 'ASC');

        if( $searchQuery ) {
            $products->where(function($query) use($searchQuery) {

                $searchQuery = '%' . $searchQuery . '%';

                $query->where('product.name', 'LIKE', $searchQuery)
                    ->orWhere('product.description', 'LIKE', $searchQuery)
                    ->orWhere('product.navision_id', 'LIKE', $searchQuery)
                    ->orWhere('manufacturer.name', 'LIKE', $searchQuery);

            });
        }

        $products->join('manufacturer', 'product.manufacturer_id', '=', 'manufacturer.id')
                    ->leftJoin('product_images', function($query) {
                        $query->on('product.id', '=', 'product_images.product_id')->where('main_image', 1);
                    })
                    ->limit(PAGE_SIZE, $page);

        if( $this->productCategory != null ) {
            $products->whereIn('product_category_id', $this->productCategory);
        }

        if( $manufacturer ) {
            $products->where('manufacturer_id', function($query) use($manufacturer) {
                $query->select('id')->from(with(new Manufacturer)->getTable())->where('slug', $manufacturer);
            });
        }

        $products = $products->get();

        $products = $products->map(function($product) use($includeMetas) {

            // URLify the image so we can display it on the requesting website.
            if( $product->image != null ) {
                $product->image = url($product->image);
            }

            // Model number that is null will destroy the sort, so we give it 100k.
            if( $product->model_number == null ) {
                $product->model_number = 100000;
            }

            // The product listing page requires some metas for configuration
            if( $includeMetas ) {

                // Count how many manufacturers have products in this search
                if( array_key_exists($product->manslug, $this->manufacturerMetas) ) {
                    $this->manufacturerMetas[$product->manslug]['count']++;
                } else {
                    $this->manufacturerMetas[$product->manslug] = [
                        'id' => $product->manslug,
                        'name' => $product->manufacturer,
                        'image' => asset($product->manimg),
                        'count' => 1
                    ];
                }

            }

            return $product;

        });

        if( $sortBy ) { $sorted = $products->sortBy($sortBy); }

        $response->products = $sortBy ? $sorted->values()->all() : $products;

        if( $includeMetas ) {

            $this->metas['manufacturers'] = [];

            // Clean up the array, we don't need the key.
            foreach($this->manufacturerMetas as $mfMeta) {
                $this->metas['manufacturers'][] = $mfMeta;
            }

            $response->metas = $this->metas;

        }

        return $response;

    }

    protected function sitemap() {

        $products = self::select('product.name','product.manufacturer_id','product_images.image', 'product.slug', 'manufacturer.slug as mfslug')
          ->where('product.active', 1)
          ->join('manufacturer', 'product.manufacturer_id' , '=', 'manufacturer.id')
          ->leftJoin('product_images', function($query) {
              $query->on('product.id', '=', 'product_images.product_id')->where('main_image', 1);
          })
          ->get();

        return $products;

    }

    protected function hideValues($product) {

        unset($product->active);
        unset($product->created_at);
        unset($product->updated_at);
        if(isset($product->navisionData)) {
            unset($product->navisionData);
        }

    }

    protected function single($request, $id) {

        // Return single product + related related products
        $product = self::where('slug', $id)
            ->with('manufacturer')
            ->with('navisionData')
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
        $sizes = ProductSizes::getSizesFor($product->id);

        $images = $images->map(function($image) {

            $image->image = url($image->image);
            return $image;

        });

        $product->images = $images;
        $product->technical_information = $techInfo;
        $product->sizes = count($sizes) > 0 ? $sizes : [];

        if( $product->price && $product->navisionData ) {
            $product->displayPrice =
                number_format($product->navisionData->UnitPricePerSalesUOMVAT, 0, '.', '.') . ' kr.';
        }

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
                "AND a.id != {$originalProduct->id} " .
                "ORDER BY b.totalCount DESC, rand() LIMIT 3"));

        if( count($related) > 0 ) {
            foreach($related as $product) {
                if( $product->image != null ) {
                    $product->image = url($product->image);
                }
            }
        }

        return $related;

    }

    public function navisionData() {
        return $this->hasOne('App\Models\ProductNavisionData', 'product_id');
    }

    public function manufacturer() {
        return $this->belongsTo('App\Models\Manufacturer', 'manufacturer_id');
    }

}
