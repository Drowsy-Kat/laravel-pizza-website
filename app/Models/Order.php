<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'delivery_method_id', /* other fillable fields */];

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }
}
