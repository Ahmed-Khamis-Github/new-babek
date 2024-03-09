<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;
use App\Models\Nationality;
/**
 * @extends \Illuminate\Database\Eloquent\Model<\App\Models\Dashboard\Employer>
 */
class Employer extends Model
{
    protected $table = 'employers';
    protected $fillable = [ 'ar_name','en_name', 'user_id', 'company_id','phone', 'gender', 'email', 'job_title_id', 'nationality_id', 'country_id','job_title'];

    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
   

    public function nationality()
    {
        
        return $this->belongsTo(Nationality::class);
    }
    public function jobTitle()
    {
        return $this->belongsTo(jobTitle::class);
    }

}
  