<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobDispatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LogoutController;
use App\Models\Staff;
use App\Models\Material;
use App\Models\Provider;
use App\Models\Client;
use App\Models\Project;
use App\Models\Job;
use App\Models\JobDispatch;
use App\Models\User;
use App\Helper\MyHelper;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/under_construction', function () {
    return view('under_construction');
})->middleware(['auth'])->name('under_construction');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/after_login', function () {
    return view('after_login');
})->middleware(['auth'])->name('after_login');

Route::get('/home_page', function () {
	session_start();
    return view('home_page');
})->middleware(['auth'])->name('home_page');

Route::get('/assistant_home_page', function () {
	session_start();
    return view('assistant_home_page');
})->middleware(['auth'])->name('assistant_home_page');

Route::get('/home_page_old', function () {
    return view('home_page_old');
})->middleware(['auth'])->name('home_page1');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::group(['middleware' => ['auth']], function() {
	// Logout Route
	Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
 });

//////////////////////////////// For Staffs ////////////////////////////////
Route::get('/staff_main', function () {
    return view('staff_main');
})->middleware(['auth'])->name('staff_main');

Route::get('staff_selected', function (Request $request) {
    return view('staff_selected');
})->middleware(['auth'])->name('staff_selected');

Route::get('job_combination_staff_selected', function (Request $request) {
    return view('job_combination_staff_selected');
})->middleware(['auth'])->name('job_combination_staff_selected');

Route::post('job_combination_msg_to_staff', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$msg		= $_POST['msg'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To send msg:'.$msg." to staff ".$staff_id.' for job '.$job_id.'.', '');

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	$association->jobdsp_msg_from_admin = $msg;
	$res = $association->save();
	if (!$res) {
		Log::Info('Failed to send msg '.$msg." to staff ".$staff_id.' for job '.$job_id.'.', '');
		return "msgToStaffOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Sent msg:'.$msg." to staff ".$staff_id.' for job '.$job_id.' OK.', '');
		return "msgToStaffOK=true";	
	}
})->middleware(['auth'])->name('job_combination_msg_to_staff');

Route::post('job_combination_msg_to_admin', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$msg		= $_POST['msg'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To send msg:'.$msg.' to admin for job '.$job_id.'.', '');

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	$association->jobdsp_msg_from_staff = $msg;
	$res = $association->save();
	if (!$res) {
		Log::Info('Failed to send msg '.$msg.' to admin for job '.$job_id.'.', '');
		return "msgToAdminOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Sent msg:'.$msg.' to admin for job '.$job_id.' OK.', '');
		return "msgToAdminOK=true";	
	}
})->middleware(['auth'])->name('job_combination_msg_to_admin');

Route::post('job_assistants_complete', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To complete job '.$job_id.".", '');

	$job 		= Job::where('id', $job_id)->first();
	$job->job_assistants_complete 	= $job->job_assistants_complete + 1;
	$job->job_status 				= $job->job_assistants_complete.'/'.$job->job_total_active_assistants.' COMPLETED';
	$res = $job->save();
	if (!$res) {
		Log::Info('Failed to update job_assistants_complete for staff '.$staff_id.' and job '.$job_id."!");
		return "jobCompleteOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Changed job_assistants_complete to '.$job->job_assistants_complete.' for job '.$job_id.' OK.', '');
		$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
		$association->jobdsp_status = 'COMPLETED';
		$res = $association->save();
		if (!$res) {
			Log::Info('Staff '.$staff_id.' failed to complete the job '.$job_id."!");
			return "jobCompleteOK=false";	
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Completed job '.$job_id.' OK.', '');
			Log::Info('Staff '.$staff_id.' completed the job '.$job_id." successfully.");
			if ($job->job_assistants_complete == $job->job_total_active_assistants) {
				$project = project::where('id', $job->job_proj_id)->first();
				$project->proj_jobs_complete = $project->proj_jobs_complete + 1;
				$project->proj_status = $project->proj_jobs_complete.'/'.$project->proj_total_active_jobs.' COMPLETED';
				$res = $project->save();
				if (!$res) {
					Log::Info('Failed to update proj_jobs_complete for staff '.$staff_id.' and job '.$job_id."!");
					return "jobCompleteOK=false";	
				} else {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Change the proj_jobs_complete to '.$job->job_assistants_complete.' for job '.$job_id.' OK.', '');
				}
			}
			return "jobCompleteOK=true";	
		}
	}
})->middleware(['auth'])->name('job_assistants_complete');

Route::post('job_combination_staff_remove', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To remove the association of job '.$job_id." and assistant ".$staff_id.".", '');

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	$association->jobdsp_status = 'DELETED';
	$res = $association->save();
	if (!$res) {
		Log::Info('Failed to remove the association of job '.$job_id." and assistant ".$staff_id.".", '');
		return "staffRemoveOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Removed the association of job '.$job_id." and assistant ".$staff_id." OK.", '');
		return "staffRemoveOK=true";	
	}
})->middleware(['auth'])->name('job_combination_staff_remove');

Route::get('job_dispatch', function (Request $request) {
		return view('job_dispatch');
})->middleware(['auth'])->name('job_dispatch');

Route::get('job_dispatch_by_adding', function (Request $request) {
    return view('job_dispatch_by_adding');
})->middleware(['auth'])->name('job_dispatch_by_adding');

Route::post('job_dispatch_to_staff', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$job 		= Job::where('id', $job_id)->first();
	$bound		= JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->first();
	
	MyHelper::LogStaffAction(Auth::user()->id, 'To dispatch job '.$job_id.' to staff '.$staff_id.'.', '');
	
	if ($bound) {	// association existed
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Dispatched job '.$job_id.' to staff '.$staff_id.', but skipped as no need.', '');
		Log::Info('Association existed, so no need to dispatch job '.$job_id.'to staff '.$staff_id."!");
		return "jobDispatchOK=true";	
	} else {
		$association = new JobDispatch;

		if ($association) {
			$association->jobdsp_job_id = $job_id;
			$association->jobdsp_staff_id = $staff_id;
			$association->jobdsp_status = 'CREATED';
			$res = $association->save();
			if (!$res) {
				Log::Info('Failed to dispatch job '.$job_id.'to staff '.$staff_id."!");
				return "jobDispatchOK=false";	
			} else {
				$job->job_total_assistants 			= $job->job_total_assistants + 1;
				$job->job_total_active_assistants	= $job->job_total_active_assistants + 1;
				$res = $job->save();
				if (!$res) {
					Log::Info('Failed to update job_total_assistants and job_total_active_assistants while dispatch job '.$job_id.'to staff '.$staff_id."!");
					return "jobDispatchOK=false";	
				} else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Dispatched job '.$job_id.' to staff '.$staff_id.' OK.', '');
					Log::Info('Successfully dispatched job '.$job_id.'to staff '.$staff_id."!");
					return "jobDispatchOK=true";	
				}
			}
		} else {
			Log::Info('Failed to new a JobDispatch object for job '.$job_id.'and staff '.$staff_id."!");
			return "jobDispatchOK=false";	
		}
	}
})->middleware(['auth'])->name('job_dispatch_to_staff');

Route::get('staff_condition_selected', function (Request $request) {
    return view('staff_condition_selected');
})->middleware(['auth'])->name('staff_condition_selected');

Route::get('/staff_add', function () {
    return view('staff_add');
})->middleware(['auth'])->name('staff_add');

Route::get('/staff_delete', [StaffController::class, 'delete'])->middleware(['auth'])->name('staff_delete');

//////////////////////////////// For Materials ////////////////////////////////
Route::get('/material_main', function () {
    return view('material_main');
})->middleware(['auth'])->name('material_main');

Route::get('/material_add', function () {
    return view('material_add');
})->middleware(['auth'])->name('material_add');

Route::get('/material_selected', function () {
    return view('material_selected');
})->middleware(['auth'])->name('material_selected');

Route::get('/material_delete', [MaterialController::class, 'delete'])->middleware(['auth'])->name('material_delete');

Route::post('/material_update', [MaterialController::class, 'update'])->middleware(['auth'])->name('material_update');

Route::get('/drywall_main', function () {
    return view('drywall_main');
})->middleware(['auth'])->name('drywall_main');

Route::get('drywall_selected', function (Request $request) {
    return view('drywall_selected');
})->middleware(['auth'])->name('drywall_selected');

Route::get('/drywall_add', function () {
    return view('drywall_add');
})->middleware(['auth'])->name('drywall_add');

Route::get('/drywall_delete', function () {
 	$id = $_GET['id'];
	$material = Material::where('id', $id)->first();
	$material->mtrl_status    = "DELETED";
	$materialName = $material->mtrl_name;
	$res = $material->save();
	if (!$res) {
		return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', 'The material, <span style="font-weight:bold;font-style:italic;color:red">'.$materialName.'</span>, cannot be deleted for some reason.');	
	} else {
		return redirect()->route('op_result.material', ['materialType'=>'DRYWALL SHEET'])->with('status', 'The material, <span style="font-weight:bold;font-style:italic;color:blue">'.$materialName.'</span>, has been deleted successfully.');	
	}
 })->middleware(['auth'])->name('drywall_delete');

 Route::post('/drywall_update', [MaterialController::class, 'update'])->name('drywall_update');

 Route::get('/material_associate', function () {
    return view('material_associate');
})->middleware(['auth'])->name('material_associate');

 Route::post('mtrl_associate_with_job', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$mtrl_id	= $_POST['mtrl_id'];
	$job 		= Job::where('id', $job_id)->first();
	$material 	= Material::where('id', $mtrl_id)->first();

	if ($material) {
		$material->mtrl_job_id = $job_id;
		$res = $material->save();
		if (!$res) {
			Log::Info('Failed to associate material '.$mtrl_id.' with the job '.$job_id."!");
			return "mtrlAssociateOK=false";	
		} else {
			Log::Info('Successfully associate material '.$mtrl_id.' with the job '.$job_id."!");
			return "mtrlAssociateOK=true";	
		}
	} else {
		Log::Info('Failed to access the material '.$mtrl_id."!");
		return "mtrlAssociateOK=false";	
	}
})->middleware(['auth'])->name('mtrl_associate_with_job');

//////////////////////////////// For Projects ////////////////////////////////
Route::get('/project_main', function () {
    return view('project_main');
})->middleware(['auth'])->name('project_main');

Route::get('project_selected', function (Request $request) {
    return view('project_selected');
})->middleware(['auth'])->name('project_selected');

Route::get('/project_add', function () {
    return view('project_add');
})->middleware(['auth'])->name('project_add');

Route::post('/project_add', function (Request $request) {

	$cName = str_replace("&nbsp;", " ", $_POST['proj_cstmr_name']);

	MyHelper::LogStaffAction(Auth::user()->id, 'Added project for client '.$cName, '');

	$client = Client::where('clnt_name', $cName)->first();

	if ($client) {
		$project = new Project;
		if ($project) {
			$project->proj_cstmr_id 	= $client->id;
			$project->proj_total_active_jobs	= $_POST['proj_total_active_jobs'];
			// $project->proj_total_jobs	= strval($project->proj_total_jobs + 1);
			$project->proj_status 		= $_POST['proj_status'];
			$project->proj_notes		= $_POST['proj_notes'];
			$project->proj_my_creation_timestamp = $_POST['proj_my_creation_timestamp'];
	
			$res = $project->save();

			if (!$res) {
                Log::Info('Staff '.Auth::user()->id.' failed to add the new project for client '.$cName);
				return "pausedReason = Data Has NOT Been inserted!";
			} else {
				$newProj = Project::where('proj_my_creation_timestamp', $_POST['proj_my_creation_timestamp'])->first();

				if ($newProj) {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Added project OK.', '');
					return $newProj->id;
				} else {
					Log::Info('Staff '.Auth::user()->id.' has added the new project for client '.$cName.', but the project object cannot be accessed');
					return "pausedReason = The project object cannot be accessed!";
				}
			}
		}
	} else {
		Log::Info('Staff '.Auth::user()->id.' tried to add a new project, but the project object cannot be created');
		return "pausedReason = The project object cannot be created!";
	}
})->middleware(['auth'])->name('project_add');

Route::get('/project_delete', [ProjectController::class, 'delete'])->name('project_delete');

//////////////////////////////// For Jobs ////////////////////////////////
Route::get('job_main', function (Request $request) {
    return view('job_main');
})->middleware(['auth'])->name('job_main');

Route::get('job_add', function (Request $request) {
    return view('job_add');
})->middleware(['auth'])->name('job_add');

Route::get('job_selected', function (Request $request) {
    return view('job_selected');
})->middleware(['auth'])->name('job_selected');

Route::get('job_combination_main', function (Request $request) {
    return view('job_combination_main');
})->middleware(['auth'])->name('job_combination_main');

Route::get('assistant_job_selected', function (Request $request) {
    return view('assistant_job_selected');
})->middleware(['auth'])->name('assistant_job_selected');

Route::get('/job_delete', [JobController::class, 'delete'])->middleware(['auth'])->name('job_delete');

// Route::post('/job_update', [JobController::class, 'update'])->name('job_update');

//////////////////////////////// For Providers ////////////////////////////////
Route::get('/provider_main', function () {
    return view('provider_main');
})->middleware(['auth'])->name('provider_main');

Route::get('provider_selected', function (Request $request) {
    return view('provider_selected');
})->middleware(['auth'])->name('provider_selected');

Route::get('provider_condition_selected', function (Request $request) {
    return view('provider_condition_selected');
})->middleware(['auth'])->name('provider_condition_selected');

Route::get('/provider_add', function () {
    return view('provider_add');
})->middleware(['auth'])->name('provider_add');

Route::get('provider_delete', [ProviderController::class, 'delete'])->middleware(['auth'])->name('provider_delete');

//////////////////////////////// For ???? ////////////////////////////////
Route::get('/dev_notes', function () {
    return view('dev_notes');
})->name('dev_notes');

Route::get('sendbasicemail', [MailController::class, 'basic_email']);

Route::get('sendhtmlemail', [MailController::class, 'html_email']);

Route::get('sendattachmentemail', [MailController::class, 'attachment_email']);

Route::post('reload_page_for_job_msg_from_admin', function() {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$job_dispatch = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	if ($job_dispatch) {
		return $job_dispatch->jobdsp_msg_from_admin;
	} else {
		Log::Info('Failed to get the JobDispatch object for job '.$job_id.' and staff '.$staff_id.' while refreshing its msg from administrator.');
	}
})->middleware(['auth'])->name('reload_page_for_job_msg_from_admin');

Route::post('reload_page_for_job_msg_from_staff', function() {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$job_dispatch = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	if ($job_dispatch) {
		return $job_dispatch->jobdsp_msg_from_staff;
	} else {
		Log::Info('Failed to get the JobDispatch object for job '.$job_id.' and staff '.$staff_id.' while refreshing its msg from staff.');
	}
})->middleware(['auth'])->name('reload_page_for_job_msg_from_staff');

//////////////////////////////// For Clients ////////////////////////////////
Route::get('/client_main', function () {
    return view('client_main');
})->middleware(['auth'])->name('client_main');

Route::get('client_selected', function (Request $request) {
    return view('client_selected');
})->middleware(['auth'])->name('client_selected');

Route::get('client_condition_selected', function (Request $request) {
    return view('client_condition_selected');
})->middleware(['auth'])->name('client_condition_selected');

Route::get('/client_add', function () {
    return view('client_add');
})->middleware(['auth'])->name('client_add');

Route::get('client_delete', [ClientController::class, 'delete'])->middleware(['auth'])->name('client_delete');

//////////////////////////////// For Dispatch ////////////////////////////////
Route::get('/dispatch_main', function () {
	return view('dispatch_main');
})->middleware(['auth'])->name('dispatch_main');


//////////////////////////////// For All Results ////////////////////////////////
Route::name('op_result.')->group(function () {
	Route::get('op_result_material', function () {
		return view('op_result')->withOprand('material');
	})->middleware(['auth'])->name('material');

	Route::get('op_result_staff', function () {
		return view('op_result')->withOprand('staff');
	})->middleware(['auth'])->name('staff');

	Route::get('op_result_project', function () {
		if (isset($_GET['status'])) {
			$status = str_replace("&nbsp;", " ", $_GET['status']);
			session(['status' => $status]);
		}
		return view('op_result')->withOprand('project');
	})->middleware(['auth'])->name('project');

	Route::get('op_result_job', function () {
		return view('op_result')->withOprand('job');
	})->middleware(['auth'])->name('job');

	Route::get('op_result_provider', function () {
		return view('op_result')->withOprand('provider');
	})->middleware(['auth'])->name('provider');

	Route::get('op_result_client', function () {
		return view('op_result')->withOprand('client');
	})->middleware(['auth'])->name('client');

	Route::get('op_result_user', function () {
		return view('op_result')->withOprand('user');
	})->middleware(['auth'])->name('user');

	Route::get('op_result_dispatch', function () {
		return view('op_result')->withOprand('dispatch');
	})->middleware(['auth'])->name('dispatch');

	Route::post('/staff_result', [StaffController::class, 'store'])->name('staff_add');
	Route::post('/staff_update', [StaffController::class, 'update'])->name('staff_update');

	Route::post('/material_result', [MaterialController::class, 'store'])->name('material_add');
	Route::post('/material_update', [MaterialController::class, 'update'])->name('material_update');

	// Route::post('/material_result', [MaterialController::class, 'store'])->name('drywall_add');
	// Route::post('/material_update', [MaterialController::class, 'update'])->name('drywall_update');

	Route::post('/project_result', [ProjectController::class, 'store'])->name('project_add');
	Route::post('/project_update', [ProjectController::class, 'update'])->name('project_update');

	Route::post('/job_result', [JobController::class, 'store'])->name('job_add');
	Route::post('/job_update', [JobController::class, 'update'])->name('job_update');

	Route::post('/provider_result', [ProviderController::class, 'store'])->name('provider_add');
	Route::post('/provider_update', [ProviderController::class, 'update'])->name('provider_update');

	Route::post('/client_result', [ClientController::class, 'store'])->name('client_add');
	Route::post('/client_update', [ClientController::class, 'update'])->name('client_update');

	Route::post('/system_user_result', [UserController::class, 'store'])->name('system_user_add');
	Route::post('/system_user_update', [UserController::class, 'update'])->name('system_user_update');

});

//////// For Misc

require __DIR__.'/auth.php';
