<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model {

    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected function getImagesFor( $id ) {

        return self::select('id', 'main_image', 'product_id', 'image')->where('product_id', $id)->where('active', 1)->get();

    }

    protected function storeImage( $id, $path ) {

        return self::create([
            'product_id' => $id,
            'image' => $path
        ]);

    }

    protected function activeCount($id) {

        return self::where('product_id', $id)->where('active', 1)->count();

    }

    protected function setMainImage($productId, $imageId) {

        self::where('product_id', $productId)->update([
            'main_image' => 0
        ]);

        $update = self::where('id', $imageId)->where('active', 1)->update([
            'main_image' => 1
        ]);

        return $update;

    }

}
