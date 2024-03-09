<?php

namespace App\Http\Controllers\Frontend\Sponsore;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Dashboard\Employer;
use App\Models\Dashboard\EmployerFile;
use App\Models\Dashboard\jobTitle;
use App\Models\Nationality;
use App\Models\Dashboard\Sponsore;
use App\Models\Dashboard\SponsoreFile;
use Illuminate\Http\Request;

class SponsoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employer::where('user_id', auth()->user()->id)->orderBy('id')->get();

        $sponsored = Sponsore::with('user')->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);

        if($request->employer){
            $sponsored = Sponsore::where('employer_id', $request->employer)->orderBy('created_at', 'desc')->paginate(5);
        }
        return view('frontend.dashboard.pages.sponsore.index', compact('sponsored', 'employees'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employers = Employer::where('user_id', auth()->user()->id)->orderBy('id')->get();
        $nationalities = Nationality::all();
        $job_titles = jobTitle::all();
        return view('frontend.dashboard.pages.sponsore.create', compact('employers', 'nationalities', 'job_titles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar_name' => 'required|string',
            'en_name' => 'required|string',
            'employer_id' => 'required|exists:employers,id',
            'email' => 'required|email|unique:sponsores,email',
            'phone' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|exists:nationalities,id',
            
            'relative_relation' => 'required|string',
        ]);


        $data = $request->all() ;

  
         $dialCode = $data['dial_code'];
 
         // Concatenate the dial code and mobile number
         $fullMobileNumber = $dialCode . $data['phone'];

         $data['phone'] = $fullMobileNumber ;

         $sponsored = Sponsore::create($data);

        return redirect()->route('sponsore.index')->with('success', 'Sponsore created successfully.');
    }


    public function search(Request $request)
    {
        $employeeName = $request->input('employee_name');

        $sponsors = Sponsore::where('en_name', 'LIKE', '%' . $employeeName . '%')
            ->orWhere('ar_name', 'LIKE', '%' . $employeeName . '%')
            ->get();

        return view('frontend.dashboard.pages.sponsore.index', ['sponsored' => $sponsors]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sponsore = Sponsore::findOrFail($id);
        $files = SponsoreFile::where('sponsore_id', $id)->orderBy('created_at', 'desc')->get();

        return view('frontend.dashboard.pages.sponsore.show', compact('sponsore', 'files'));
    }
    public function show_single(string $id)
    {

        $sponsored = Sponsore::where('employer_id', $id)->orderBy('created_at', 'desc')->get();

        return view('frontend.dashboard.pages.sponsore.show_employer_sponsored', compact('sponsored'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sponsored = Sponsore::findOrFail($id);
        $employers = Employer::where('user_id', auth()->user()->id)->orderBy('id')->get();
        $nationalities = Nationality::all();
        $job_titles = jobTitle::all();
        return view('frontend.dashboard.pages.sponsore.edit', compact('sponsored', 'employers', 'nationalities', 'job_titles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'ar_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sponsores,email,' . $id,
            'phone' => 'required|regex:/[0-9]+/',
            'relative_relation' => 'required|string|max:255',
         ], [
            'email.unique' => 'The email address is already in use.',
            'phone.regex' => 'Phone number should only contain numbers.',
         ]);
        $sponsored = Sponsore::findOrFail($id);
        $sponsored->update($request->all());

        return redirect()->route('sponsore.index')->with('success', 'sponsored updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sponsored = Sponsore::findOrFail($id);
        $sponsored->delete();

        return redirect()->route('sponsore.index')->with('success', 'sponsore deleted successfully.');
    }
}