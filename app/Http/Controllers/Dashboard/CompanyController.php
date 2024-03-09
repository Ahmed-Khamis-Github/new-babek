<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use RealRashid\SweetAlert\Facades\Alert;


class CompanyController extends Controller
{
    public function index()
    {

        $companies = Company::orderBy('created_at', 'desc')->paginate(8);

        return view('dashboard.companies.index', compact('companies'));
    }


    public function create()
    {

        return view('dashboard.companies.create');
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'unique_id' => $this->generateUniqueId(),
        ]);

        Alert::success('Unique ID', $company->unique_id);



        return redirect()->route('companies.index')->with('success', 'Company Added Successfully');
    }

    public function edit(Company $company)
    {


        return view('dashboard.companies.edit', compact('company'));
    }


    public function update(Request $request, Company $company)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email,' . $company->id,
            'unique_id' => 'required|string|size:9|unique:companies,unique_id,' . $company->id,
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $company->name = $request->name;
        $company->email = $request->email;

        $company->unique_id = $request->unique_id;

        $company->save();

        Alert::success('Success', "Company Updated Successfully");


        return redirect()->route('companies.index');
    }


    public function destroy(Company $company)
    {


        $company->delete();

        Alert::success('Success', "Company Deleted Successfully");

        return redirect()->route('companies.index');
    }


    public function generateUniqueId($length = 9)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
