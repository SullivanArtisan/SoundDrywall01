<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FileUploadController extends Controller
{
   public function showUploadFile(Request $request) {
      // Validation
      $request->validate([
        'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
      ]); 

      if($request->file('file')) {
         $file = $request->file('file');
         $filename = time().'_'.$file->getClientOriginalName();

         // File upload location
         $location = './pic';		// when release to product, test if it can be changed to a more appropriate path, such as: domain_root/storage/app/public; right now, it's under the public folder!

         // Upload file
         $file->move($location,$filename);

         // Session::flash('message','Upload Successfully.');
		   Session::put('success', 'Upload Successfully (for file: '.$location.'/'.$filename.')');
		   Session::put('uploadPath', $location."/".$filename);
         // Session::flash('alert-class', 'alert-success');
		   return redirect()->route('system_user_pic_upload');	
      }else{
         // Session::flash('message','File not uploaded.');
         // Session::flash('alert-class', 'alert-danger');
		   return redirect('system_user_result')->with('status', 'File not uploaded');	
      }

      // return redirect('/');
   }
}
