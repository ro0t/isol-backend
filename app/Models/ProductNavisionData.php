<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNavisionData extends Model {
    protected $table = 'product_nav_data_import';
    protected $guarded = [];

    protected $primaryKey = 'product_id';

    public function product() {
        return $this->belongsTo('App\Models\Product', 'id');
    }
}