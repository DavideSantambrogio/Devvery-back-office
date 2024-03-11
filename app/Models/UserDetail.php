<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    public $fillable = ['vat_number', 'phone', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
