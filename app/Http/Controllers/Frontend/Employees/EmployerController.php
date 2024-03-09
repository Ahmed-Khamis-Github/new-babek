<?php

namespace App\Http\Controllers\Frontend\Employees;

// use App\Events\AddEmployee as EventsAddEmployee;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Dashboard\Employer;
use App\Models\Dashboard\EmployerFile;
use App\Models\Dashboard\jobTitle;
use App\Models\Nationality;
use App\Models\User;
use App\Notifications\addEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use App\Events\AddEmployee as EventsAddEmployee;




class EmployerController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::where('user_id', auth()->user()->id)->orderBy('id')->get();
        $job_titles = jobTitle::all();
    
        $employeesQuery = Employer::with(['user', 'company', 'jobTitle'])
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc');
    
        if ($request->company) {
            $employeesQuery->where('company_id', $request->company);
        }
    
        $employees = $employeesQuery->paginate(5);
    
        return view('frontend.dashboard.pages.employee.index', compact('employees', 'companies', 'job_titles'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $compaines = Company::where('user_id', auth()->user()->id)->orderBy('id')->get();
        $nationalities = Nationality::all();
        $job_titles = jobTitle::all();
        return view('frontend.dashboard.pages.employee.create', compact('compaines', 'nationalities', 'job_titles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'phone' => 'required|regex:/[0-9]+/',
            'company_id' => 'required|exists:companies,id',
            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|exists:nationalities,id',
             'job_title'=>'nullable'
         ]);


         $data = $request->all() ;

  
         $dialCode = $data['dial_code'];
 
         // Concatenate the dial code and mobile number
         $fullMobileNumber = $dialCode . $data['phone'];

         $data['phone'] = $fullMobileNumber ;
         

         $data['user_id']= Auth::id() ;

         $user_id = auth()->user()->id;
 
        $employer = Employer::create($data);
        // $employer->notify(new addEmployee($employer));
        // $users = User::all();

        //  $admins=Admin::all();
        //  $user=User::find(Auth::user()->id);
         event(new EventsAddEmployee($employer));


        //  Notification::send($admins,new addEmployee($employer));






        return redirect()->route('employee.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)

    {


        $employer = Employer::findOrFail($id);

        $files = EmployerFile::where('employer_id', $id)->orderBy('created_at', 'desc')->get();



        // $getID= DB::table('notifications')->where('data->newemployee_id',12)->pluck('id');

        // DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);


        //  auth()->user()->unreadNotifications->markAsRead();


        return view('frontend.dashboard.pages.employee.show', compact('employer', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employer = Employer::findOrFail($id);

        return view('frontend.dashboard.pages.employee.edit', compact('employer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $employer = Employer::findOrFail($id);

        $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email,' . $employer->id,
            'phone' => 'required|regex:/[0-9]+/',

         ]);

        $employer->update($request->all());

        return redirect()->route('employee.index')->with('success', 'employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employer = Employer::findOrFail($id);
        $employer->delete();

        return redirect()->route('employee.index')->with('success', 'Company deleted successfully.');
    }
}
