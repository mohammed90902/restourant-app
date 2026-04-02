<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['table_number', 'status', 'capacity'];





    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
