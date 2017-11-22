<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model {

    protected $table = 'manufacturer';
    protected $guarded = ['id'];

    // Allow us to set the ID to slug
    public $incrementing = false;

    protected function getActive() {

        return self::select('slug as id', 'name', 'website', 'image')->where('active', 1)->get();

    }

    protected function getActiveWithIds() {

        return self::select('id', 'name')->where('active', 1)->get();

    }

    protected function getList() {

        return self::orderBy('id', 'ASC')->limit(100)->get();

    }

}
