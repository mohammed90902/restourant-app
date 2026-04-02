<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food'; 
    protected $fillable = ['sub_category_id', 'name_en', 'name_ar', 'name_ckb', 'price', 'is_available', 'image', 'user_id'];


    public function sub_category(){
        return $this->belongsTo(subCategory::class,'sub_category_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
