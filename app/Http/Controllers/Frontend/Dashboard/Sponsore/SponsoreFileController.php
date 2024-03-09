<?php

namespace App\Http\Controllers\Frontend\Dashboard\Sponsore;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Sponsore;
use App\Models\Dashboard\SponsoreFile;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\Models\Dashboard\Employer;
use App\Models\Dashboard\EmployeeFileOrders;
use App\Traits\ApiBitrix;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;



class SponsoreFileController extends Controller
{
    use ApiBitrix;

    public function FileForm($id)
    {
        $sponsore = Sponsore::findOrFail($id);
        return view('frontend.dashboard.pages.sponsoreFile.fileForm', compact('sponsore'));
    }

    public function addSponsoreFile(Request $request, $id)
    {
        $sponsore = Sponsore::findOrFail($id);
        // dd($sponsore);
        $sponsoreName = $sponsore->en_name;
        $employerName = Employer::findOrFail($sponsore->employer_id)->name;

        $validated = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'required|mimes:doc,pdf,docx,jpeg,png',
        ]);

        $fileUploader = new FileUploader();
        $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Sponsore/' . str_replace(' ', '', $employerName) . '/' . str_replace(' ', '', $sponsoreName) . '/' . date('Y-M-D'), [
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
        $sponsorefile = new SponsoreFile();
        $sponsorefile->name = $request->input('name');
        $sponsorefile->filename = $uploadedFile["fileUrl"];
        $sponsorefile->start_date = $request->input('start_date');
        $sponsorefile->end_date = $request->input('end_date');
        $sponsorefile->sponsore_id = $id;
        // dd($sponsorefile);
        $sponsorefile->save();
        FacadesAlert::success('File Added');
        return redirect()->route('sponsore.show', $sponsore->id)->with('success', 'Sponsore file added successfully.');
    }
    public function show($id)
    {
        $file = SponsoreFile::findOrFail($id);
        $sponsore = Sponsore::findOrFail($file->sponsore_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.sponsoreFile.fileShow', compact('file', 'sponsore'));
    }

    public function edit($id)
    {
        $file = SponsoreFile::findOrFail($id);
        $sponsore = Sponsore::findOrFail($file->sponsore_id);

        return view('frontend.dashboard.pages.sponsoreFile.fileEdit', compact('file', 'sponsore'));
    }
    public function update(Request $request, $id)
    {

        $file = SponsoreFile::findOrFail($id);

        $sponsore = Sponsore::findOrFail($file->sponsore_id);
        $employerName = Employer::findOrFail($sponsore->employer_id)->name;

        $sponsoreName = $sponsore->en_name;
        if ($request->hasFile('file')) {
            $fileUploader = new FileUploader();

            $uploadedFile = $fileUploader->uploadFile($request->file('file'), 'uploads/Sponsore/' . str_replace(' ', '', $employerName) . '/' . str_replace(' ', '', $sponsoreName) . '/' . date('Y-M-D'), [
                'file' => 'required|file|max:10000',
                // 'mimes' => 'image/jpeg|image/png|image/gif|application/pdf',
            ]);
            $file->filename = $uploadedFile["fileUrl"];
        }
        $file->update($request->all());
        FacadesAlert::success('File Updated Successfully');
        return redirect()->route('sponsore.show', $sponsore->id)->with('success', 'Sponsore file updated successfully.');
    }

    public function destroy($id)
    {
        $file = SponsoreFile::findOrFail($id);
        $file->delete();
        FacadesAlert::success('File Deleted');
        return redirect()->back()->with('success', 'Sponsore file deleted successfully.');
    }


    public function renew(Request $request, $id)
    {
        $note = $request->note;
        $file = SponsoreFile::findOrFail($id);
        $sponsore = Sponsore::findOrFail($file->sponsore_id);
        $sponsoreName = $sponsore->name;
        $sponsoerId = $sponsore->id;
        $statusId = 1;
        $taskName = $sponsoreName . ' Sponsore File';
        $taskDesc = $file->name . '<br>' . $note;
        // $employerOrder = new EmployeeFileOrders();
        // $employerOrder->file_id = $id;
        // $employerOrder->employer_id = $employerId;
        // $employerOrder->status_id = $statusId;
        // $employerOrder->save();

        $data = $this->createTask(155, $taskName, $taskDesc);
        if ($data['status'] == '200') {
            # code...
            FacadesAlert::success('Request sent Successfully');
        } else {
            FacadesAlert::error('Request failed');
        }
        return redirect()->route('sponsore.show', $sponsore->id)->with('success', 'Sponsore file updated successfully.');
    }
    public function renew_request($id)
    {
        $file = SponsoreFile::findOrFail($id);
        $sponsore = Sponsore::findOrFail($file->sponsore_id);
        // $img = Storage::url($file->filename);
        // $img = Storage::url('Asset_11.png');
        return view('frontend.dashboard.pages.sponsoreFile.renew', compact('file', 'sponsore'));
    }
}
