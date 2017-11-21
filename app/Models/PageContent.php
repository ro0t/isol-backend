<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model {

    protected $table = 'page_content';
    protected $primaryKey = 'page_id';
    protected $guarded = [];

    protected function getContent( $id ) {

        $pc = self::where('page_id', $id)->firstOrCreate(['page_id' => $id]);

        return $pc->content;

    }

}
