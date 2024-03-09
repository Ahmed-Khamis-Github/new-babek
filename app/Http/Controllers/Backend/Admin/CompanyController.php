<?php

namespace App\Http\Controllers\backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\Dashboard\CompanyFile;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $companies = Company::with('user', 'country')->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.pages.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all() ;

        return view('backend.pages.company.create',compact('countries')) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
            'name' => 'required|string',
            'ar_name' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'mobile' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'company_data' => 'nullable|json',
        ]);

        $data = $request->all() ;

 
        $dialCode = $data['dial_code'];

        // Concatenate the dial code and mobile number
        $fullMobileNumber = $dialCode . $data['mobile'];

        $company = Company::create([
            'name' => $data['name'],
            'name' => $data['ar_name'],
            'country_id' => $data['country_id'],
            'mobile' => $fullMobileNumber,
            'user_id' => $data['user_id'],
            'company_data' =>json_encode([
                "regesterd" => $data['regesterd'],
                "capital" => $data['capital'],
                "activity" => $data['activity'],
                "note" => $data['note'],
            ])

            ,
        ]);

        // You can do additional actions if needed

        return redirect()->route('all_companies.index')->with('success','Company has been added successfully') ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        $data = json_decode($company->company_data, true);
        $files = CompanyFile::where('company_id', $id)->orderBy('created_at', 'desc')->get();
        return view('backend.pages.company.show', compact('company', 'data', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company= Company::findOrFail($id) ;

        $countries = Country::get() ;
        $data = json_decode($company->company_data, true);
         return view ('backend.pages.company.edit',compact('company','countries','data')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'mobile' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'company_data' => 'nullable|json',
        ]);

        $data = $request->all() ;



        $company = Company::findOrFail($id) ;


        $company->update([
            'name' => $data['name'],
            'country_id' => $data['country_id'],
            'mobile' => $data['mobile'],
            'user_id' => $data['user_id'],
            'company_data' =>json_encode([
                "regesterd" => $data['regesterd'],
                "capital" => $data['capital'],
                "activity" => $data['activity'],
                "note" => $data['note'],
            ])

            ,
        ]);

        return redirect()->route('all_companies.index')->with('success','Company has been Updated successfully') ;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $company = Company::findOrFail($id) ;

      $company->delete() ;
      return redirect()->route('all_companies.index')->with('success','Company has been Deleted successfully') ;

    }
}
