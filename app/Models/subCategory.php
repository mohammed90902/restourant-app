<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subCategory extends Model
{
    protected $fillable = ['category_id', 'name_en', 'name_ar', 'name_ckb', 'image'];



    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'sub_category_id');
    }
}
