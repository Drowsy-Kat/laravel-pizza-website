<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $table = 'delivery_method';
    protected $fillable = ['name'];

    // establish database relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
