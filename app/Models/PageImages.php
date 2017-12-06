<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageImages extends Model {

    protected $table = 'page_images';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected function getImagesFor( $id ) {

        $images = self::select('id', 'image')->where('page_id', $id)->where('active', 1)->get();

        if( count($images) > 0 ) {

            $images->map(function($img) {

                $img->image = asset($img->image);

                return $img;

            });

            return $images;

        }

        return null;

    }

    protected function storeImage( $id, $path ) {

        return self::create([
            'page_id' => $id,
            'image' => $path
        ]);

    }

}
