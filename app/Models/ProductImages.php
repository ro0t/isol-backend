<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model {

    protected $table = 'product_images';
    protected $primaryKey = 'product_id';
    protected $guarded = [];

    protected function getImagesFor( $id ) {

        return self::where('product_id', $id)->where('active', 1)->get();

    }

}
