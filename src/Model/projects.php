<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    protected $fillable = ['projekt_id','kodproj','nazwa','opis','user_id'];
    public $table = 'zlecenies';
}
