<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
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
