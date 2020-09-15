<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class studentModel extends Model
{
    use SoftDeletes;
    protected $table = 'student';

    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}
