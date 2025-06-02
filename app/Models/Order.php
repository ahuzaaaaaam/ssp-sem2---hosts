<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'status',
        'subtotal',
        'tax',
        'total',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'payment_method',
        'payment_status',
    ];
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
