<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Material;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'mtrl_name'   => 'required',
                'mtrl_amount'      => 'required',
            ]);
            
            $material = new Material;
            $job = Job::where('job_name', $request->job_name)->first();
    
            if ($material && $job) {
                $material->mtrl_job_id      = $job->id;
                $material->mtrl_name        = $request->mtrl_name;
                $material->mtrl_status      = "CREATED";
                $material->mtrl_type        = $request->mtrl_type;
                $material->mtrl_size        = $request->mtrl_size;
                $material->mtrl_size_unit   = $request->mtrlsizeunitinput;
                $material->mtrl_source      = $request->mtrl_source;
                $material->mtrl_shipped_by  = $request->mtrl_shipped_by;
                $material->mtrl_amount      = $request->mtrl_amount;
                $material->mtrl_amount_unit = $request->mtrl_amount_unit;
                $material->mtrl_amount_left = $request->mtrl_amount;
                $material->mtrl_price       = $request->mtrl_price;
                $saved = $material->save();
            } else {
                $err_msg = "Material or Job object cannot be accessed while adding a new material.";
                Log::Info($err_msg." / ".$request->job_name);
                return "Something wrong while adding the new material.";
            }
            
            if(!$saved) {
                $err_msg = "Material ".$request->mtrl_name." cannot be added.";
                Log::Info($err_msg);
                return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', ' <span style="color:red">Material Has NOT Been inserted!</span>');
            } else {
                return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', 'The new material,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->mtrl_name.'</span>, has been inserted successfully.');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'mtrl_name'   => 'required',
                'mtrl_amount'      => 'required',
            ]);
            
            $material = Material::where('id', $request->mtrl_id)->first();
            $job = Job::where('job_name', $request->job_name)->first();
    
            if ($material && $job) {
                $material->mtrl_job_id      = $job->id;
                $material->mtrl_name        = $request->mtrl_name;
                // $material->mtrl_status      = $request->mtrl_status;
                $material->mtrl_type        = $request->mtrl_type;
                $material->mtrl_size        = $request->mtrl_size;
                $material->mtrl_size_unit   = $request->mtrlsizeunitinput;
                $material->mtrl_source      = $request->mtrl_source;
                $material->mtrl_shipped_by  = $request->mtrl_shipped_by;
                $material->mtrl_amount      = $request->mtrl_amount;
                $material->mtrl_amount_unit = $request->mtrl_amount_unit;
                $material->mtrl_amount_left = $request->mtrl_amount_left;
                $material->mtrl_price       = $request->mtrl_price;
                $saved = $material->save();
            } else {
                $err_msg = "Material or Job object cannot be accessed while updating a material.";
                Log::Info($err_msg." / ".$request->job_name);
                return "Something wrong while updating the material.";
            }
            
            if(!$saved) {
                $err_msg = "Material ".$request->mtrl_name." cannot be updated.";
                Log::Info($err_msg);
                return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', ' <span style="color:red">Material Has NOT Been updated!</span>');
            } else {
                return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', 'The material,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->mtrl_name.'</span>, has been updated successfully.');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
