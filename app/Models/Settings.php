<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

    protected $table = 'settings';
    protected $guarded = ['id'];

    protected function getContent( $key ) {

        return self::select('content')->where('key', $key)->first();

    }

    protected function updateContent( $key, $content ) {

        $settings = self::where('key', $key)->first();

        if( $settings != null ) {

            $settings->content = $content;
            $settings->save();

        }

    }

}
