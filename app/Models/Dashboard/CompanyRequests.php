<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRequests extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'content', 'price' ];
    protected $table = 'companyrequests';
    
}
