<?php namespace App\Models;

use \DB;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {

    protected $table = 'product_category';
    protected $guarded = ['id'];

    // Allow us to set the ID to slug
    public $incrementing = false;

    protected function getParents() {

        return self::where('active', 1)
            ->where('parent', 0)
            ->orderBy('id', 'ASC')
            ->get();

    }

    protected function getParentsAndChildren($id = 0) {

        $categories = DB::select('CALL getProductCategories(?);', [$id]);
        $results = collect($categories);

        foreach($results as $ancestor) {
            $ancestor->children = $ancestor->childCount > 0 ?
                $this->getParentsAndChildren($ancestor->id)
                : [];
        }

        return $results;

    }

    protected function getParentsAndChildrenIds($id) {
        $ids = [];
        $results = self::getParentsAndChildren($id);

        foreach( $results as $category ) {
            $ids[] = $category->id;
            foreach( $category->children as $child ) {
                $ids[] = $child->id;
            }
        }

        return $ids;
    }

    protected function getChildren( $parentId ) {
        $children = self::where('parent', $parentId)
            ->where('active', 1)
            ->orderBy('order', 'ASC')
            ->get();

        return $children;
    }

    protected function getWebsiteItems() {

        $parents = self::select('id', 'name')
            ->where('active', 1)
            ->where('parent', 0)
            ->where('show_website', 1)
            ->get();

        foreach($parents as $parent) {

            // Find and return all the children of each parent
            $parent->children = self::select('id', 'name')
                ->where('parent', $parent->id)
                ->where('show_website', 1)
                ->where('active', 1)
                ->orderBy('name', 'ASC')
                ->get();

        }

        return $parents;

    }

    protected function getMenuItems( $slugAsId = true ) {

        // The Ember website wants slug as id, but if you want the real id pass false into this function.
        $type = $slugAsId ? 'slug as id' : 'id';

        return self::select( $type , 'name')->where('active', 1)->where('show_menu', 1)->orderBy('order', 'ASC')->get();

    }

    protected function getList() {

        return self::where('active', 1)->orderBy('id', 'ASC')->limit(100)->get();

    }

}
