<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable=['name_en','name_ar','name_ckb','image']; 
   


   public function user(){
    return $this->belongsTo(User::class,'user_id');
   }
    public function sub_categories(){
        return $this->hasMany(subCategory::class,'user_id');
    
    }

    

}

