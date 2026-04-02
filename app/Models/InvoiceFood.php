<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceFood extends Model
{
    protected $table = 'invoice_food';
    protected $fillable = ['food_id', 'invoice_id', 'price', 'quantity', 'status', 'user_id', 'notes'];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
