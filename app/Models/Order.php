<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'customer_id', 'total_amount'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class)->withPivot('quantity_ordered');
    }
}
