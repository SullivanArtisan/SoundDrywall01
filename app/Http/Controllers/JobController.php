<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_type'      => 'required',
                'job_address'   => 'required',
                'job_city'      => 'required',
                'job_province'  => 'required',
            ]);
            
            $job = new Job;
            $project = Project::where('id', $request->proj_id)->first();
    
            if ($job && $project) {
                $job->job_proj_id   = $request->job_proj_id;
                $job->job_name      = $request->job_name;
                $job->job_status    = "CREATED";
                $job->job_type      = $request->job_type;
                $job->job_address   = $request->job_address;
                $job->job_city      = $request->job_city;
                $job->job_province  = $request->job_province;
                $saved = $job->save();
            } else {
                $err_msg = "Job or Project object cannot be accessed while adding a new job.";
                Log::Info($err_msg);
                return "Something wrong while adding the new job.";
            }
            
            if(!$saved) {
                $err_msg = "Project P".$project->id."'s ".strval($project->proj_total_active_jobs+1)."th job cannot be added.";
                Log::Info($err_msg);
                return redirect()->route('op_result.job')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
            } else {
                $project->proj_total_active_jobs = $project->proj_total_active_jobs+1;
                $project->proj_total_jobs = $project->proj_total_jobs+1;
                $saved2 = $project->save();
                if(!$saved2) {
                    $err_msg = "Project P".$project->id."'s porj_total_jobs of ".$project->proj_total_active_jobs." cannot be increased by 1.";
                    Log::Info($err_msg);
                    return redirect()->route('op_result.job')->with('status', ' <span style="color:red">'.$err_msg.'</span>');
                } else {
                    return redirect()->route('project_selected', ['id'=>$request->proj_id, 'JobAddOk'=>$request->job_name])->with('status', 'The job <span style="font-weight:bold;font-style:italic;color:blue">'.$request->job_name.'</span>, has been inserted successfully.');
                }
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_type'      => 'required',
                'job_address'   => 'required',
                'job_city'      => 'required',
                'job_province'  => 'required',
            ]);
            
            $job = Job::where('id', $request->job_id)->first();
    
            if ($job) {
                $job->job_proj_id   = $request->job_proj_id;
                $job->job_name      = $request->job_name;
                $job->job_status    = $request->job_status;
                $job->job_type      = $request->job_type;
                $job->job_address   = $request->job_address;
                $job->job_city      = $request->job_city;
                $job->job_province  = $request->job_province;
                $saved = $job->save();
            } else {
                $err_msg = "Job object cannot be accessed while updating a job.";
                Log::Info($err_msg);
                return "Something wrong while adding the new job.";
            }
            
            if(!$saved) {
                $err_msg = "Job ".$job->job_name." cannot be updated.";
                Log::Info($err_msg);
                return redirect()->route('op_result.job')->with('status', ' <span style="color:red">Data Has NOT Been Updated!</span>');
            } else {
                return redirect()->route('project_selected', ['id'=>$request->job_proj_id, 'JobUpdateOk'=>$request->job_name])->with('status', 'The job <span style="font-weight:bold;font-style:italic;color:blue">'.$request->job_name.'</span>, has been updated successfully.');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
