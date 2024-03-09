<?php

namespace App\Http\Controllers\Frontend\Dashboard\Employees;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Models\Dashboard\Employer;
use App\Models\Dashboard\EmployerFile;
use App\Models\Dashboard\EmployeeFileOrders;
use App\Traits\ApiBitrix;

use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;


class EmployerFileController extends Controller
{
    use ApiBitrix;

    public function FileForm($id){
        $employer = Employer::findOrFail($id);
        return view('frontend.dashboard.pages.employeeFile.fileForm', compact('employer'));
    }

    public function addEmployerFile(Request $request, $id){
        $employer = Employer::findOrFail($id);
        $employerName = $employer->en_name;
        $companyName = Company::findOrFail($employer->company_id)->name;
        $validated = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'required|mimes:doc,pdf,docx,jpeg,png',
        ]);

        $fileUploader = new FileUploader();
        $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Employer/'.str_replace(' ', '',$companyName).'/'.str_replace(' ', '',$employerName).'/'.date('Y-M-D'), [
            'file' => 'required|file|max:10000',
            // 'mimes' => 'image/jpeg|image/png|image/gif|application/pdf',
        ]);
        // dd($uploadedFile);
        if (empty($uploadedFile['errors'])) {
            // The file was uploaded successfully.
        } else {
            // The file upload failed.
            // $uploadedFile['errors'] will contain an array of error messages.
        }
        // dd($uploadedFile);
        $employerfile = new EmployerFile();
        $employerfile->name = $request->input('name');
        $employerfile->filename = $uploadedFile["fileUrl"];
        $employerfile->start_date = $request->input('start_date');
        $employerfile->end_date = $request->input('end_date');
        $employerfile->employer_id = $id;
        $employerfile->save();
        FacadesAlert::success('File Added');
        return redirect()->route('employee.show', $employer->id)->with('success', 'Employer file added successfully.');
    }
    public function show($id){
        $file = EmployerFile::findOrFail($id);
        $employer = Employer::findOrFail($file->employer_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.employeeFile.fileShow', compact('file', 'employer'));
    }

    public function edit($id){
        $file = EmployerFile::findOrFail($id);
        $employer = Employer::findOrFail($file->employer_id);

        return view('frontend.dashboard.pages.employeeFile.fileEdit', compact('file', 'employer'));
    }
    public function update(Request $request, $id){

        $file = EmployerFile::findOrFail($id);

        $employer = Employer::findOrFail($file->employer_id);
        $companyName = Company::findOrFail($employer->company_id)->name;

        $employerName = $employer->en_name;
        if($request->hasFile('file')){
            $fileUploader = new FileUploader();
        
            $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Employer/'.str_replace(' ', '',$companyName).'/'.str_replace(' ', '',$employerName).'/'.date('Y-M-D'), [
                'file' => 'required|file|max:10000',
                // 'mimes' => 'image/jpeg|image/png|image/gif|application/pdf',
            ]);
            $file->filename = $uploadedFile["fileUrl"];
        }
        $file->update($request->all());
        FacadesAlert::success('File Updated Successfully');
        return redirect()->route('employee.show', $employer->id)->with('success', 'Employer file updated successfully.');

    }

    public function destroy($id){
        $file = EmployerFile::findOrFail($id);
        $file->delete();
        FacadesAlert::success('File Deleted');
        return redirect()->back()->with('success', 'Employer file deleted successfully.');
    }


    public function renew(Request $request, $id){
        $note = $request->note;

        $file = EmployerFile::findOrFail($id);

        $employer = Employer::findOrFail($file->employer_id);
        $employerName = $employer->name;
        $employerId = $employer->id;
        $statusId = 1;
        $taskName = $employerName.' Employer File';
        $taskDesc = $file->name.'<br>'.$note;
        // $employerOrder = new EmployeeFileOrders();
        // $employerOrder->file_id = $id;
        // $employerOrder->employer_id = $employerId;
        // $employerOrder->status_id = $statusId;
        // $employerOrder->save();

        $data = $this->createTask(155 , $taskName, $taskDesc);
        if ($data['status'] == '200') {
            # code...
            FacadesAlert::success('Request sent Successfully');
        }else{
            FacadesAlert::error('Request failed');
        }
        return redirect()->route('employee.show', $employer->id)->with('success', 'Employer file updated successfully.');

    }
    public function renew_request($id){
        $file = EmployerFile::findOrFail($id);
        $employer = Employer::findOrFail($file->employer_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.employeeFile.renew', compact('file', 'employer'));
    }
}

