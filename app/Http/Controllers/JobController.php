<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use App\Models\Job;
use App\Models\Material;
use App\Models\JobDispatch;
use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
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
            ]);

            MyHelper::LogStaffAction(Auth::user()->id, 'Added job '.$request->job_name.' (city= '.$request->job_city.').', '');
            
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
                $job->job_total_assistants          = 0;
                $job->job_total_active_assistants   = 0;
                $job->job_assistants_complete       = 0;
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
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Added job OK.', '');
                $project->proj_total_active_jobs = $project->proj_total_active_jobs+1;
                $project->proj_total_jobs = $project->proj_total_jobs+1;
                if (strstr($project->proj_status, 'COMPLETED')) {
                    $project->proj_status = $project->proj_jobs_complete.'/'.$project->proj_total_active_jobs.' COMPLETED';
                }
                $saved2 = $project->save();
                if(!$saved2) {
                    $err_msg = "Project P".$project->id."'s porj_total_jobs of ".$project->proj_total_active_jobs." cannot be increased by 1.";
                    Log::Info($err_msg);
                    return redirect()->route('op_result.job')->with('status', ' <span style="color:red">'.$err_msg.'</span>');
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Changed proj_total_active_jobs to '.$project->proj_total_active_jobs.' OK while adding job.', '');
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
            ]);

            MyHelper::LogStaffAction(Auth::user()->id, 'Updated job '.$request->job_id.' (city= '.$request->job_city.').', '');
            
            $job = Job::where('id', $request->job_id)->first();
    
            if ($job) {
                $job->job_proj_id   = $request->job_proj_id;
                $job->job_name      = $request->job_name;
                $job->job_status    = $request->job_status;
                $job->job_type      = $request->job_type;
                $job->job_address   = $request->job_address;
                $job->job_city      = $request->job_city;
                $job->job_province  = $request->job_province;
                $job->job_desc      = $request->job_desc;
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
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated job '.$request->job_id.' OK.', '');
                return redirect()->route('project_selected', ['id'=>$request->job_proj_id, 'JobUpdateOk'=>$request->job_name])->with('status', 'The job <span style="font-weight:bold;font-style:italic;color:blue">'.$request->job_name.'</span>, has been updated successfully.');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted job of ID '.$id, '');

            $job = Job::where('id', $id)->first();
            if ($job) {
                $job->job_status    = "DELETED";
                $project = Project::where('id', $job->job_proj_id)->first();
                if ($project) {
                    $job_name = $job->job_name;
                    $res = $job->save();
                    if (!$res) {
                        $err_msg = "Job ".$id." cannot be deleted.";
                        Log::Info($err_msg);
                        return redirect()->route('op_result.job')->with('status', 'The job cannot be deleted for some reason.');	
                    } else {
                        MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted job '.$id.' OK.', '');
                        $project->proj_total_active_jobs = strval($project->proj_total_active_jobs - 1);
                        $res2 = $project->save();
                        if (!$res2) {
                            Log::Info('Staff '.Auth::user()->id.' tried to delete a job, but the proj_total_active_jobs of job '.$id.' object cannot be accessed');
                            return redirect()->route('op_result.job')->with('status', "The project's proj_total_active_jobs cannot be decreased.");	
                        } else {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Changed proj_total_active_jobs to '.$project->proj_total_active_jobs.' OK while deleting job '.$id, '');
                            
                            $materials = Material::where('mtrl_job_id', $id)->get();
                            foreach ($materials as $material) {
                                if ($material->mtrl_status == "DELETED") {
                                    continue;
                                }
                        
                                $material->mtrl_status = "DELETED";
                                $res = $material->save();
                                if (!$res) {
                                    Log::Info("Material ".$material->id." cannot be deleted.");
                                    return redirect()->route('op_result.project')->with('status', "The job has been deleted, but its material cannot be deleted for some reason.");	
                                } else {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, "Deleted job's material '.$material->id.' OK.", "");
                                }
                            }

                            $dispatches = JobDispatch::where('jobdsp_job_id', $id)->get();
                            foreach ($dispatches as $dispatch) {
                                if ($dispatch->jobdsp_status == "DELETED") {
                                    continue;
                                }
                        
                                $dispatch->jobdsp_status = "DELETED";
                                $res = $dispatch->save();
                                if (!$res) {
                                    Log::Info("Dispatch ".$dispatch->id." cannot be deleted.");
                                    return redirect()->route('op_result.project')->with('status', "The job has been deleted, but its dispatch cannot be deleted for some reason.");	
                                } else {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, "Deleted job's dispatch '.$dispatch->id.' OK.", "");
                                }
                            }

                            return redirect()->route('project_selected', ['id'=>$job->job_proj_id, 'JobDeleteOk'=>$job_name]);
                        }
                    }
                } else {
                    Log::Info('Staff '.Auth::user()->id.' tried to delete a job, but the project object cannot be accessed while deleting the job'.$id);
                    return redirect()->route('op_result.job')->with('status', "The project object cannot be accessed while deleting the job.");	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a job, but the job '.$id.' object cannot be accessed');
                return redirect()->route('op_result.job')->with('status', ' <span style="color:red">The job object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
