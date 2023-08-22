<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Session;

class ProjectAttachmentController extends Controller
{
    public function UploadFile(Request $request) {
        // Validation
        $request->validate([
          'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]); 
  
        if($request->file('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
  
            $proj_id = $request->input('proj_id');
            MyHelper::LogStaffAction(Auth::user()->id, 'To upload attachment '.$filename.' for project '.$proj_id, '');

            // File upload location
            $location = './project_attachments';		// when release to product, test if it can be changed to a more appropriate path, such as: domain_root/storage/app/public; right now, it's under the public folder!
  
            // Upload file
            $file->move($location, $filename);


  
            // Session::flash('message','Upload Successfully.');
            Session::put('success', 'Upload Successfully!! (for file: '.$filename.')');
            // Session::put('uploadPath', $location."/".$filename);
            // Session::flash('alert-class', 'alert-success');
            
            MyHelper::LogStaffActionResult(Auth::user()->id, 'Uploaded attachment '.$filename.' for project '.$proj_id.' OK.', '');

            MyHelper::LogStaffAction(Auth::user()->id, 'To create attachment DB object for '.$filename.' in project '.$proj_id, '');
            $attachment = new ProjectAttachment;
            if ($attachment) {
                $attachment->atchmnt_proj_id = $proj_id;
                $attachment->atchmnt_file_name = $filename;
                $attachment->atchmnt_status = 'CREATED';
                $saved = $attachment->save();

                if(!$saved) {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to create attachment DB object for '.$filename.' in project '.$proj_id, '900');
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Created attachment DB object for '.$filename.' in project '.$proj_id.' OK.', '');
                }
            } else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to create a new attachment DB object for '.$filename.' in project '.$proj_id, '900');
            }
            
            return redirect()->route('project_attachment_main', ['id'=>$proj_id]);	
        }else{
            // Session::flash('message','File not uploaded.');
            // Session::flash('alert-class', 'alert-danger');
            return redirect('project_attachment_main', ['id'=>$proj_id])->with('status', 'File not uploaded');	
        }
  
        // return redirect('/');
     }
  }
