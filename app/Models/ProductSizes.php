<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizes extends Model {

    protected $table = 'product_size';
    protected $guarded = [];
    public $hidden = ['created_at', 'updated_at', 'id', 'product_id', 'active'];

    protected function clearSizes($productId) {

        self::where('product_id', $productId)->delete();

    }

    protected function addSize($productId, $sizeDetails) {

        return self::create([
            'product_id' => $productId,
            'size_description' => $sizeDetails
        ]);

    }

    protected function getSizesFor($productId) {

        return self::where('product_id', $productId)->where('active', 1)->get();

    }

}
