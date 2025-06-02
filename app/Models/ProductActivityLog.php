<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProductActivityLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_activity_logs';
    protected $fillable = [
        'user_id', 'product_id', 'activity', 'ip', 'user_agent', 'created_at'
    ];
    public $timestamps = false;
}
