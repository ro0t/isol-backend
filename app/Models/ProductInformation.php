<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model {

    protected $table = 'product_technical_information';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected function getInformationFor( $id ) {

        return self::where('product_id', $id)->get();

    }

    protected function storeData( $productId, $data ) {

        $stored = [];

        foreach( $data as $item ) {

            $key = $item['name'];
            $value = $item['value'];

            $pi = self::create([
                'product_id' => $productId,
                'key' => $key,
                'value' => $value
            ]);

            if( $pi ) { $stored[] = $pi->id; }

        }

        ProductInformation::whereNotIn('id', $stored)->where('product_id', $productId)->delete();

    }

}
