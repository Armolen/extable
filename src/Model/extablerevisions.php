<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class extablerevisions extends Model
{
    protected $fillable = ['oldconnection_id','newconnection_id','code'];
    public $table = 'extable_revisions';
}
