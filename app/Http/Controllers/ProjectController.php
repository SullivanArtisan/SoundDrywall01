<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Job;
use App\Models\Material;
use App\Models\JobDispatch;
use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'proj_cstmr_id'     => 'required',
			// 'proj_total_jobs'   => 'required',
		]);
		
        $project = new Project;
        $client = Client::where('clnt_name', $request->proj_cstmr_name)->first();

        if ($project && $client) {
            $project->proj_cstmr_id             = $client->id;
            // $project->proj_total_active_jobs    = $request->proj_total_active_jobs;
            // $project->proj_total_jobs           = $request->proj_total_active_jobs;
            $project->proj_status               = $request->proj_status;
            $project->proj_notes                = $request->proj_notes;
            $project->proj_my_creation_timestamp = $request->proj_my_creation_timestamp;
            $saved = $project->save();
        } else {
            return "Something wrong while adding the new project.";
        }
        
        if($saved) {
            $newProj = Project::where('proj_my_creation_timestamp', $request->proj_my_creation_timestamp)->first();

            if ($newProj) {
                return $newProj->id;
            } else {
                return "NNOO";
            }
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'proj_address'      => 'required',
            'proj_city'         => 'required',
            // 'proj_cstmr_id'     => 'required',
            // 'proj_total_jobs'   => 'required',
        ]);

		MyHelper::LogStaffAction(Auth::user()->id, 'Updated project '.$request->id, '');
        
        $project = Project::where('id', $request->id)->first();
		if ($project) {
            $client = Client::where('clnt_name', $request->proj_cstmr_name)->first();

            if (!isset($client)) {
                Log::Info('Staff '.Auth::user()->id.' tried to update a project, but the project client cannot be accessed');
                return redirect()->route('op_result.project')->with('status', ' <span style="color:red">The connection between project and client is broken!</span>');
            }

            $project->proj_cstmr_id             = $client->id;
            // $project->proj_total_active_jobs    = $request->proj_total_active_jobs;
            // $project->proj_total_jobs           = $request->proj_total_active_jobs;
            $project->proj_address              = $request->proj_address;
            $project->proj_city                 = $request->proj_city;
            $project->proj_province             = $request->proj_province;
            $project->proj_postcode             = $request->proj_postcode;
            $project->proj_status               = $request->proj_status;
            $project->proj_notes                = $request->proj_notes;
            $saved = $project->save();
            
            if(!$saved) {
				Log::Info('Staff '.Auth::user()->id.' failed to update the project'.$request->id);
                return redirect()->route('op_result.project')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
            } else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated project '.$request->id.' OK.', '');
                return redirect()->route('op_result.project')->with('status', 'The project has been updated successfully.');
            }
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to update a project, but the project object cannot be accessed');
			return redirect()->route('op_result.project')->with('status', ' <span style="color:red">The project object cannot be accessed!</span>');
		}
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted project of ID '.$id, '');

            $project = Project::where('id', $id)->first();
            if ($project) {
                $project->proj_status = "DELETED";
                $res = $project->save();
                if (!$res) {
                    $err_msg = "Project ".$id." cannot be deleted.";
                    Log::Info($err_msg);
                    return redirect()->route('op_result.project')->with('status', 'The project cannot be deleted for some reason.');	
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted project '.$id.' OK.', '');

                    $jobs = Job::where('job_proj_id', $id)->get();
                    foreach ($jobs as $job) {
                        if ($job->job_status == "DELETED") {
                            continue;
                        }

                        $job->job_status = "DELETED";
                        $res = $job->save();
                        if (!$res) {
                            Log::Info("Job ".$job->id." cannot be deleted.");
                            return redirect()->route('op_result.project')->with('status', 'The project has been deleted, but the didpatched job cannot be deleted for some reason.');	
                        } else {
                            MyHelper::LogStaffActionResult(Auth::user()->id, "Deleted project's didpatched job '.$job->id.' OK.", "");

                            $materials = Material::where('mtrl_job_id', $job->id)->get();
                            foreach ($materials as $material) {
                                if ($material->mtrl_status == "DELETED") {
                                    continue;
                                }
                        
                                $material->mtrl_status = "DELETED";
                                $res = $material->save();
                                if (!$res) {
                                    Log::Info("Material ".$material->id." cannot be deleted.");
                                    return redirect()->route('op_result.project')->with('status', "The project's didpatched job has been deleted, but its material cannot be deleted for some reason.");	
                                } else {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, "Deleted project's didpatched job's material '.$material->id.' OK.", "");
                                }
                            }

                            $dispatches = JobDispatch::where('jobdsp_job_id', $job->id)->get();
                            foreach ($dispatches as $dispatch) {
                                if ($dispatch->jobdsp_status == "DELETED") {
                                    continue;
                                }
                        
                                $dispatch->jobdsp_status = "DELETED";
                                $res = $dispatch->save();
                                if (!$res) {
                                    Log::Info("Dispatch ".$dispatch->id." cannot be deleted.");
                                    return redirect()->route('op_result.project')->with('status', "The project's didpatched job has been deleted, but its dispatch cannot be deleted for some reason.");	
                                } else {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, "Deleted project's didpatched job's dispatch '.$dispatch->id.' OK.", "");
                                }
                            }
                        }
                    }

                    return redirect()->route('op_result.project')->with('status', 'The project has been deleted successfully.');	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a project, but the project '.$id.' object cannot be accessed');
                return redirect()->route('op_result.project')->with('status', ' <span style="color:red">The project object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
