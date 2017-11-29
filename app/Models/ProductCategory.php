<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {

    protected $table = 'product_category';
    protected $guarded = ['id'];

    // Allow us to set the ID to slug
    public $incrementing = false;

    protected function getParents() {

        return self::where('active', 1)->whereNull('parent')->orderBy('id', 'ASC')->get();

    }

    protected function getParentsAndChildren() {

        $parents = self::getParents();

        foreach($parents as $parent) {

            // Find and return all the children of each parent
            $parent->children = self::where('parent', $parent->id)->where('active', 1)->orderBy('name', 'ASC')->get();

        }

        return $parents;

    }

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
