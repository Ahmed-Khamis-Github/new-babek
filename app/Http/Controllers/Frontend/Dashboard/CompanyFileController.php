<?php

namespace App\Http\Controllers\Frontend\Dashboard;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Dashboard\CompanyFile;
use App\Models\Dashboard\CompanyFileOrder;
use App\Traits\ApiBitrix;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class CompanyFileController extends Controller
{
    use ApiBitrix;

    public function FileForm($id){
        $company = Company::findOrFail($id);
        return view('frontend.dashboard.pages.companyFile.fileForm', compact('company'));
    }

    public function addCompanyFile(Request $request, $id){
        // dd($request->all()) ;
        $company = Company::findOrFail($id);
        $companyName = $company->name;
        $validated = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'required|mimes:doc,pdf,docx,jpeg,png',
        ]);

        $fileUploader = new FileUploader();
        $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Company/'.str_replace(' ', '',$companyName).'/'.date('Y-M-D'), [
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
        $companyfile = new CompanyFile();
        $companyfile->name = $request->input('name');
        $companyfile->filename = $uploadedFile["fileUrl"];
        $companyfile->start_date = $request->input('start_date');
        $companyfile->end_date = $request->input('end_date');
        $companyfile->company_id = $id;
        $companyfile->save();
        FacadesAlert::success('File Added');
        return redirect()->route('companies.show', $company->id)->with('success', 'Company file added successfully.');
    }
    public function show($id){
        $file = CompanyFile::findOrFail($id);
        $company = Company::findOrFail($file->company_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.companyFile.fileShow', compact('file', 'company'));
    }

    public function edit($id){
        $file = CompanyFile::findOrFail($id);
        return view('frontend.dashboard.pages.companyFile.fileEdit', compact('file'));
    }
    public function update(Request $request, $id){

        $file = CompanyFile::findOrFail($id);

        $company = Company::findOrFail($file->company_id);
        $companyName = $company->name;
        if($request->hasFile('file')){
            $fileUploader = new FileUploader();
        
            $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Company/'.str_replace(' ', '',$companyName).'/'.date('Y-M-D'), [
                'file' => 'required|file|max:10000',
                // 'mimes' => 'image/jpeg|image/png|image/gif|application/pdf',
            ]);
            $file->filename = $uploadedFile["fileUrl"];
        }
        $file->update($request->all());
        FacadesAlert::success('File Updated Successfully');
        return redirect()->route('companies.show', $company->id)->with('success', 'Company file updated successfully.');

    }

    public function destroy($id){
        $file = CompanyFile::findOrFail($id);
        $file->delete();
        FacadesAlert::success('File Deleted');
        return redirect()->back()->with('success', 'Company file deleted successfully.');
    }

    public function renew(Request $request, $id){
        $note = $request->note;
        $file = CompanyFile::findOrFail($id);
        $company = Company::findOrFail($file->company_id);
        $companyName = $company->name;
        $companyId = $company->id;
        $statusId = 1;
        $taskName = $companyName.' Company File';
        $taskDesc = $file->name.'<br>'.$note;

        // $companyOrder = new CompanyFileOrder();
        // $companyOrder->file_id = $id;
        // $companyOrder->company_id = $companyId;
        // $companyOrder->status_id = $statusId;
        // $companyOrder->save();

        $data = $this->createTask(155 , $taskName, $taskDesc);
        if ($data['status'] == '200') {
            # code...
            FacadesAlert::success('Request sent Successfully');
        }else{

            FacadesAlert::error('Request failed');
        }
        return redirect()->route('companies.show', $company->id)->with('success', 'Company file updated successfully.');

    }
    public function renew_request($id){
        $file = CompanyFile::findOrFail($id);
        $company = Company::findOrFail($file->company_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.companyFile.renew', compact('file', 'company'));
    }
}
