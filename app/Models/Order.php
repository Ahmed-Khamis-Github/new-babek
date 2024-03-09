<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'location',
        'destination',
        'seller_name',
        'customer_name',
        'customer_notes',
        'order_status',
        'attachment',   
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'order_user')
            ->withTimestamps()
            ->withPivot('chosen')
            ->using(OrderUser::class);
    }
}
