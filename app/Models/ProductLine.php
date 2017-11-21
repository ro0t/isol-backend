<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model {

    protected $table = 'product_line';
    protected $primaryKey = 'nav_product_id';
    protected $guarded = [];

    protected function findQuery( $string ) {

        if( !empty($string) && strlen($string) > 2 ) {

            return self::where('nav_product_id', 'like', $string . '%')
                ->inRandomOrder()
                ->limit(15)
                ->get();

        }

        return null;

    }

}
