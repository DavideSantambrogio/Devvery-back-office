<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'cover_image',
        'slug',
        'type_id',
        'description'
    ];

    public function setNameAttribute($_name)
    {
        $this->attributes['name'] = $_name;
        $this->attributes['slug'] = Str::slug($_name, '&');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}
