<?php

namespace App\Models;

use App\Traits\LangDb;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use Searchable, LangDb;

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
