<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFileOrder extends Model
{
    use HasFactory;
    protected $fillable = [ 'file_id', 'company_id', 'status_id'];
    protected $table = 'company_file_orders';
}
