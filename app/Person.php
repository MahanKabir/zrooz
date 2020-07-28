<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'code', 'phone', 'email', 'address', 'date', 'image', 'parent', 'individual', 'value'];
}
