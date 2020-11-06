<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'product_sku'
    ];

    /**
     * Get the user that owns a message.
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'purchases')->withTimeStamps();;
    }
}
