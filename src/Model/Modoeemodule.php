<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;
use ciscmodule\modoee\Model\Modoeemodule as module;

class Modoeemodule extends module
{

    public function extables() {
        return $this->hasMany(extable::class,"module_id");
        
    }
    
}
