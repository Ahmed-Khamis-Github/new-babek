<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::orderBy('id')->get();
        $countries_names = [];

        foreach($countries as $country){
            $countries_names[] = ($country->name);
        };
        return view('auth.register', compact('countries', 'countries_names'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }



    protected function create_user(Request $data)
    {
         $data->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
       
        
        $partner = [];
        $partner_country = [];
        for($i = 0; $i < $data['partners']; $i++){
           $partner["Partner".$i] = $data["Partner" .$i];
           $partner_country["Partner_country".$i] = $data["Partner_country" .$i];
        };
        $user = null;

        DB::transaction(function () use ($data, &$user, $partner, $partner_country) {
            $user = User::create([
              'name' => $data['name'],
              'email' => $data['email'],
              'password' => Hash::make($data['password']),
          ]);
            // $country_id = Country::where('name', $data['country'])->firstorfail();
            // dd($country_id->id);

            $dialCode = $data['dial_code'];

        $full = $dialCode . $data['phone'];
             $company = Company::create([
                'name' => $data['company'],
                'country_id' => $data['country'],
                'mobile' => $full,
                'user_id' => $user->id,
                'company_data' =>json_encode([
                    "partners" => $data['partners'],
                    "Patner_name" => $partner,
                    "Patner_country" => $partner_country,
                    "regesterd" => $data['regesterd'],
                    "capital" => $data['capital'],
                    "activity" => $data['activity'],
                    "note" => $data['note'],
                ])

                ,
            ]);
            // json_encode($data)
        });

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

}
