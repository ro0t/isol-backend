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

            if( count($parent->children) == 0 ) {
                $parent->children = [];
            }

        }

        return $parents;

    }

    protected function getChildren( $parentSlug ) {

        $parent = self::where('slug', $parentSlug )->where('active', 1)->first();

        if( $parent ) {

            $children = self::where('parent', $parent->id)->where('active', 1)->orderBy('name', 'ASC')->get();

            $children->map(function($child) {

                if( $child->image != null ) {
                    $child->hasImage = 'yes';
                    $child->image = asset($child->image);
                } else {
                    $child->hasImage = '';
                }

                return $child;

            });

            return $children;

        }

        return null;

    }

    protected function getWebsiteItems() {

        $parents = self::select('id', 'name')->where('active', 1)->whereNull('parent')->where('show_website', 1)->get();

        foreach($parents as $parent) {

            // Find and return all the children of each parent
            $parent->children = self::select('id', 'name')->where('parent', $parent->id)->where('show_website', 1)->where('active', 1)->orderBy('name', 'ASC')->get();

        }

        return $parents;

    }

    protected function getMenuItems() {

        return self::select('slug as id', 'name')->where('active', 1)->where('show_menu', 1)->get();

    }

    protected function getList() {

        return self::where('active', 1)->orderBy('id', 'ASC')->limit(100)->get();

    }

}
