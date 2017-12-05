<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Manufacturer extends Model {

    protected $table = 'manufacturer';
    protected $guarded = ['id'];

    // Allow us to set the ID to slug
    public $incrementing = false;

    protected function getActive() {

        return self::select('slug as id', 'name', 'website', 'image')->where('active', 1)->get();

    }

    protected function getActiveWithIds() {

        return self::select('id', 'name')->where('active', 1)->get();

    }

    protected function getList() {

        return self::orderBy('id', 'ASC')->limit(100)->get();

    }

    protected function getTotalCount() {

        $items = DB::select(DB::raw("SELECT manufacturer.id, manufacturer.slug, manufacturer.image, manufacturer.name, count(*) as count FROM manufacturer " .
                "INNER JOIN product ON manufacturer.id = product.manufacturer_id " .
                "WHERE product.active = 1 AND manufacturer.active = 1 " .
                "GROUP BY product.manufacturer_id " .
                "ORDER BY manufacturer.id ASC"));

        if( count($items) > 0 ) {

            foreach($items as $item) {

                if( isset($item->image) && $item->image != null ) {
                    $item->image = asset($item->image);
                }

                // Ember..
                unset($item->id);
                $item->id = $item->slug;
                unset($item->slug);

            }

        }

        return $items;

    }

}
