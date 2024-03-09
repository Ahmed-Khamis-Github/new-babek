<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction', 'amount', 'transaction_date'];
    public function formSubmission()
    {
        return $this->hasOne(FormSubmission::class, 'transaction_id');
    }

}
