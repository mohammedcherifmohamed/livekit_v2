<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenancy extends Model
{
    

    public function booted(){
        static::creating(function($tenant){
            $tenant->domain = $tenant->name . ".localhost";
        });
    }
}
