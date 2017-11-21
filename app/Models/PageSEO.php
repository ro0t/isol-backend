<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSEO extends Model {

    protected $table = 'page_seo';
    protected $primaryKey = 'page_id';
    protected $guarded = [];

    protected function getContent( $id ) {

        return self::where('page_id', $id)->firstOrCreate(['page_id' => $id]);

    }

}
