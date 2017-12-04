<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class Modoeescheme extends \ciscmodule\modoee\Model\Modoeescheme
{
    
    protected function module() {
        return $this->HasMany(Modoeemodule::class,"modoeeschemes_id");
    } 
}
