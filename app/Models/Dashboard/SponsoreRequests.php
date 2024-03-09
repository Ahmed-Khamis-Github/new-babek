<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsoreRequests extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'content', 'price' ];
    protected $table = 'sponsorerequests';
}
