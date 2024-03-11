<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Food extends Model
{
    protected $table = 'foods';

    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'price', 'description', 'vegan', 'celiac', 'available', 'cover_image', 'category_id'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity_ordered');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
