<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class worklog extends Model
{
    protected $fillable = ['attributes','ip'];
    public $table = 'extable_worklog';
}
