<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    protected $table = 'employees';
    protected $guarded = [];

    protected function getActive() {

        return self::where('active', 1)->orderBy('id', 'ASC')->get();

    }

}
