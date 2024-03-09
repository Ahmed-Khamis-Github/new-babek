<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFileOrders extends Model
{
    use HasFactory;
    protected $fillable = [
      'employer_id',
      'company_id',
      'file_name',
      'renewal_date',
      'status_id',
  ];
}
  