<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model {

    protected $table = 'product_technical_information';
    protected $primaryKey = 'product_id';
    protected $guarded = [];

    protected function getInformationFor( $id ) {

        return self::where('product_id', $id)->where('active', 1)->get();

    }

}
