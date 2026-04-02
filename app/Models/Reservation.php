<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['name', 'phone_number', 'hour', 'chair', 'table_id', 'user_id'];




    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
