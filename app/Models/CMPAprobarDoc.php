<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMPAprobarDoc extends Model
{
    protected $table = 'CMP.APROBAR_DOC';
    public $timestamps=false;

    protected $primaryKey = 'COD_APROBAR_DOC';
	public $incrementing = false;
    public $keyType = 'string';
    
}
