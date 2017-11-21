<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {

    protected $table = 'product_category';
    protected $guarded = ['id'];

    // Allow us to set the ID to slug
    public $incrementing = false;

    protected function getWebsiteItems() {

        return self::select('slug as id', 'name')->where('active', 1)->where('show_website', 1)->get();

    }

    protected function getMenuItems() {

        return self::select('slug as id', 'name')->where('active', 1)->where('show_menu', 1)->get();

    }

    protected function getList() {

        return self::where('active', 1)->orderBy('id', 'ASC')->limit(100)->get();

    }

}
