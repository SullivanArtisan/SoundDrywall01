<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
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
        
        $project = Project::where('id', $request->id)->first();
        $client = Client::where('clnt_name', $request->proj_cstmr_name)->first();

        if (!isset($client)) {
            return redirect()->route('op_result.project')->with('status', ' <span style="color:red">The connection between project and client is broken!</span>');
        }

        $project->proj_cstmr_id             = $client->id;
        // $project->proj_total_active_jobs    = $request->proj_total_active_jobs;
        // $project->proj_total_jobs           = $request->proj_total_active_jobs;
        $project->proj_status               = $request->proj_status;
        $project->proj_notes                = $request->proj_notes;
        $saved = $project->save();
        
        if(!$saved) {
            return redirect()->route('op_result.project')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
        } else {
            return redirect()->route('op_result.project')->with('status', 'The project has been updated successfully.');
        }
    }
}
