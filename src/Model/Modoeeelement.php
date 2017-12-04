<?php

namespace ciscmodule\extable\Model;

use Illuminate\Database\Eloquent\Model;

class Modoeeelement extends \ciscmodule\modoee\Model\Modoeeelement
{


    public function scheme() {
        return $this->hasOne(Modoeescheme::class,'id',"modoeeschemes_id");
    }
    
}
