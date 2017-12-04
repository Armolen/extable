<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class extable extends Model
{
    protected $fillable = ['parent','child',"module_id",'kolor_koszulki','projekt_id','przekroj_przewodu','kolor_przewodu','dokladka','zlacze','status_z', 'status_do'];
    public $table = 'extable_connections';
}
