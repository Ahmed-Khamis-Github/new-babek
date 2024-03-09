<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsoreFile extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [ 'name', 'filename', 'start_date', 'end_date', 'company_id'];
    protected $table = 'sponsore_files';
}
