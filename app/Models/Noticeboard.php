<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticeboard extends Model
{
    //
    protected $fillable=[
        "subject",
        "description",
        "dept",
        "status",
    ];
}
