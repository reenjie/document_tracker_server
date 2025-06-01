<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'is_enabled',
    ];


}



//Slug : this is a unique identifier for the module | it is the route in the API