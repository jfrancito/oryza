<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBListaSerie extends Model
{
    protected $table = 'WEB.LISTASERIE';
    public $timestamps=false;

    public $incrementing = false;
    public $keyType = 'string';

}