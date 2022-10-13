<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'description', 'type', 'category', 'quantity', 'unit_cost', 'manufacturer', 'distributor', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
