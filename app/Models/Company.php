<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Country;
class Company extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'user_id', 'mobile', 'country_id', 'company_data', 'ar_name','registration_price','paid','completed'];
    protected $table = 'companies';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
