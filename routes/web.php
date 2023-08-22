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
use App\Http\Controllers\ProjectAttachmentController;
use App\Models\Staff;
use App\Models\Material;
use App\Models\Provider;
use App\Models\Client;
use App\Models\Project;
use App\Models\Job;
use App\Models\JobDispatch;
use App\Models\ProjectAttachment;
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
})->middleware(['auth', 'ChkUsrStatus'])->name('home_page');

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
		Log::Info('Failed to send msg '.$msg." to staff ".$staff_id.' for task '.$job_id.'.', '');
		return "msgToStaffOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Sent msg:'.$msg." to staff ".$staff_id.' for task '.$job_id.' OK.', '');
		return "msgToStaffOK=true";	
	}
})->middleware(['auth'])->name('job_combination_msg_to_staff');

Route::post('job_combination_msg_to_admin', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$msg		= $_POST['msg'];

	MyHelper::LogStaffAction($staff_id, 'To send msg:'.$msg.' to admin for task '.$job_id.'.', '');

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	$association->jobdsp_msg_from_staff = $msg;
	$res = $association->save();
	if (!$res) {
		Log::Info('Failed to send msg '.$msg.' to admin for task '.$job_id.'.', '');
		return "msgToAdminOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Sent msg:'.$msg.' to admin for task '.$job_id.' OK.', '');
		return "msgToAdminOK=true";	
	}
})->middleware(['auth'])->name('job_combination_msg_to_admin');

Route::post('job_assistants_complete', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To complete task '.$job_id.".", '');

	// Save the signature file
	$input_data 		= $_POST['signatrue_data'];
	$inspection_report 	= $_POST['inspection_report'];
	list($type, $signatrue_data) = explode(';', $input_data);
	list(, $signatrue_data)      = explode(',', $signatrue_data);
	$signatrue_data = base64_decode($signatrue_data);
	$sig_file = 'signature/task_'.$job_id.'_sigof_'.$staff_id.'_img.png';
	$saved_rslt = file_put_contents($sig_file, $signatrue_data);
	if (!$saved_rslt) {
		Log::Info('Failed to update job_assistants_complete for staff '.$staff_id.' and task '.$job_id."!");
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Saved task signature file '.$sig_file.' OK.', '');
	}

	$job 		= Job::where('id', $job_id)->first();
	$job->job_assistants_complete 	= $job->job_assistants_complete + 1;
	$job->job_status 				= $job->job_assistants_complete.'/'.$job->job_total_active_assistants.' COMPLETED';
	$job->job_inspection_report 	= $inspection_report;
	$res = $job->save();
	if (!$res) {
		Log::Info('Failed to update job_assistants_complete for staff '.$staff_id.' and task '.$job_id."!");
		return "jobCompleteOK=false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Changed job_assistants_complete to '.$job->job_assistants_complete.' for task '.$job_id.' OK.', '');
		$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
		$association->jobdsp_status = 'COMPLETED';
		$res = $association->save();
		if (!$res) {
			Log::Info('Staff '.$staff_id.' failed to complete the task '.$job_id."!");
			return "jobCompleteOK=false";	
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Completed task '.$job_id.' OK.', '');
			Log::Info('Staff '.$staff_id.' completed the task '.$job_id." successfully.");

			// Change all didpatched materials' statuses to 'COMPLETED', if this JobDispatch entry is completed by the superintendent
			// and create a new material for the remainder if there is any
			$staff = Staff::where('id', $staff_id)->first();
			if ($staff->role == 'SUPERINTENDENT') {
				$materials = Material::where('mtrl_job_id', $job_id)->get();
				foreach($materials as $material) {
					$material->mtrl_status = 'COMPLETED';
					$res = $material->save();
					if (!$res) {
						MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to change the status to COMPLETED for material '.$material->id.'.', '900');
					}

					$new_mtrl = new Material;
					if (!$new_mtrl) {
						MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to create a new REMAINDER material object for material '.$material->id.'.', '900');
					} else {
						if ($material->mtrl_amount_left > 0) {
							// Create a new material for the remainder
							MyHelper::LogStaffAction(Auth::user()->id, 'Added a REMAINDER material for material '.$material->id.'.', '');
							$new_mtrl->mtrl_job_id      = 0;
							$new_mtrl->mtrl_name        = $material->mtrl_name.'_remainder_'.$job->job_name;
							$new_mtrl->mtrl_model       = $material->mtrl_model;
							$new_mtrl->mtrl_status      = "CREATED";
							$new_mtrl->mtrl_type        = $material->mtrl_type;
							$new_mtrl->mtrl_size        = $material->mtrl_size;
							$new_mtrl->mtrl_size_unit   = $material->mtrl_size_unit;
							$new_mtrl->mtrl_source      = "WAREHOUSE";
							//$new_mtrl->mtrl_shipped_by  = $material->mtrl_shipped_by;
							$new_mtrl->mtrl_amount      = $material->mtrl_amount_left;
							$new_mtrl->mtrl_amount_unit = $material->mtrl_amount_unit;
							//$new_mtrl->mtrl_amount_left = $material->mtrl_amount;
							$new_mtrl->mtrl_unit_price  = $material->mtrl_unit_price;
							if ($material->mtrl_amount > 0) {
								$new_mtrl->mtrl_total_price = $material->mtrl_total_price * $material->mtrl_amount_left / $material->mtrl_amount;
							}
							$saved = $new_mtrl->save();
							if (!$saved) {
								MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to add the new REMAINDER for material '.$material->id.'.', '900');
							} else {
								MyHelper::LogStaffActionResult(Auth::user()->id, 'Added the new REMAINDER for material '.$material->id.' OK.', '');
							}
						}
					}
				}
			}

			// Change the parent project's status if necessary
			if ($job->job_assistants_complete == $job->job_total_active_assistants) {
				$project = project::where('id', $job->job_proj_id)->first();
				$project->proj_jobs_complete = $project->proj_jobs_complete + 1;
				if ($project->proj_jobs_complete < $project->proj_total_active_jobs) {
					$project->proj_status = $project->proj_jobs_complete.'/'.$project->proj_total_active_jobs.' COMPLETED';
				} else {
					$project->proj_status = 'COMPLETED';
				}
				$res = $project->save();
				if (!$res) {
					Log::Info('Failed to update proj_jobs_complete for staff '.$staff_id.' and task '.$job_id."!");
					return "jobCompleteOK=false";	
				} else {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Change the proj_jobs_complete to '.$job->job_assistants_complete.' for task '.$job_id.' OK.', '');
				}
			}
			return "jobCompleteOK=true";	
		}
	}
})->middleware(['auth'])->name('job_assistants_complete');

Route::post('job_assistant_save_working_hours_today', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$jobdsp_workinghours_today	= $_POST['jobdsp_workinghours_today'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To record today\'s working hours ('.$jobdsp_workinghours_today.') for task '.$job_id.".", '');
	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	if (!$association) {
		Log::Info('Failed to access the object for task '.$job_id." and assistant ".$staff_id.".", '');
		return "Failed";	
	} else {
		$association->jobdsp_workinghours_today 	= $jobdsp_workinghours_today;
		$association->jobdsp_workinghours_total    += $jobdsp_workinghours_today;
		$association->jobdsp_workinghours_last_time	= date('Y-m-d H:i:s', time());
		$res = $association->save();
		if (!$res) {
			Log::Info('Failed to update proj_jobs_complete for staff '.$staff_id.' and task '.$job_id."!");
			return "jobCompleteOK=false";	
		} else {
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Saved today\'s working hours ('.$jobdsp_workinghours_today.') for task '.$job_id.' OK.', '');
		}
	}
})->middleware(['auth'])->name('job_assistant_save_working_hours_today');

Route::post('job_combination_staff_remove', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To remove the association of task '.$job_id." and assistant ".$staff_id.".", '');

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->where('jobdsp_status', '<>', 'COMPLETED')->first();
	$association->jobdsp_status = 'DELETED';
	$res1 = $association->save();
	if (!$res1) {
		Log::Info('Failed to remove the dispatch of task '.$job_id." and assistant ".$staff_id.".", '');
		return "staffRemoveOK=false";	
	} else {
		$job 		= Job::where('id', $job_id)->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->first();
		if (!$job) {
			Log::Info('Failed to access the object for task '.$job_id.".", '');
		} else {
			$job->job_total_active_assistants--;
			if ($job->job_total_active_assistants == 0) {
				$job->job_status = 'CREATED';
			}
			$res2 = $job->save();
			if (!$res2) {
				Log::Info('Failed to decrease job_total_active_assistants for task '.$job_id." while removing staff ".$staff_id.".", '');
			}
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Decreased job_total_active_assistants for task '.$job_id.' OK.', '');
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Removed the association of task '.$job_id." and assistant ".$staff_id." OK.", '');
		}
		return "staffRemoveOK=true";	
	}
})->middleware(['auth'])->name('job_combination_staff_remove');

Route::post('job_combination_staff_reassociate', function (Request $request) {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$new_staff  = explode(" ", $_POST['new_staff']);

	MyHelper::LogStaffAction(Auth::user()->id, 'To change the dispatch of task '.$job_id." and assistant ".$staff_id." to ".$new_staff[0]." ".$new_staff[1].".", '');
	$staff = Staff::where('f_name', $new_staff[0])->where('l_name', $new_staff[1])->first();
	if (!$staff) {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to access staff object for '.$new_staff[0].' '.$new_staff[1].' while ressociating task '.$job_id.' assistant'.$staff_id, '900');
		return "false";
	}

	$association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->where('jobdsp_status', '<>', 'COMPLETED')->first();
	$association->jobdsp_staff_id = $staff->id;
	$res1 = $association->save();
	if (!$res1) {
		Log::Info('Failed to do the re-dispatch of task '.$job_id." and assistant ".$staff_id." to the new staff ".$staff->id.".", '');
		return "false";	
	} else {
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Did the ressociation for task '.$job_id.' assistant'.$staff_id.' to the new staff '.$staff->id.' OK.', '');
		return "staffRemoveOK=true";	
	}
	return true;
})->middleware(['auth'])->name('job_combination_staff_reassociate');

Route::post('job_combination_material_remove', function (Request $request) {
	$job_id 		= $_POST['job_id'];
	$material_id	= $_POST['material_id'];

	MyHelper::LogStaffAction(Auth::user()->id, 'To remove the dispatch of task '.$job_id." and material ".$material_id.".", '');

	$material = Material::where('id', $material_id)->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->where('mtrl_status', '<>', 'COMPLETED')->first();
	$material->mtrl_job_id = 0;
	$res = $material->save();
	if (!$res) {
		Log::Info('Failed to remove the dispatch of task '.$job_id." and material ".$material_id.".", '');
		return "materialRemoveOK=false";	
	} else {
		$job 		= Job::where('id', $job_id)->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->first();
		if (!$job) {
			Log::Info('Failed to access the object for task '.$job_id.' while removing the dispatch for material '.$material_id);
		} else {
			$job->job_total_active_materials--;
			$res2 = $job->save();
			if (!$res2) {
				Log::Info('Failed to decrease job_total_active_materials for task '.$job_id." while removing material ".$material_id.".", '');
			} else {
				MyHelper::LogStaffActionResult(Auth::user()->id, 'Decreased job_total_active_materials for task '.$job_id.' OK.', '');
			}
			MyHelper::LogStaffActionResult(Auth::user()->id, 'Removed the dispatch of task '.$job_id." and material ".$material_id." OK.", '');
		}
		return "materialRemoveOK=true";	
	}
})->middleware(['auth'])->name('job_combination_material_remove');

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
	
	if ($bound) {	// dispatch existed
		MyHelper::LogStaffActionResult(Auth::user()->id, 'Dispatched task '.$job_id.' to staff '.$staff_id.', but skipped as no need.', '');
		Log::Info('Dispatch existed, so no need to dispatch task '.$job_id.'to staff '.$staff_id."!");
		return "jobDispatchOK=true";	
	} else {
		$association = new JobDispatch;

		if ($association) {
			$association->jobdsp_job_id = $job_id;
			$association->jobdsp_staff_id = $staff_id;
			$association->jobdsp_status = 'CREATED';
			$res = $association->save();
			if (!$res) {
				Log::Info('Failed to dispatch task '.$job_id.'to staff '.$staff_id."!");
				return "jobDispatchOK=false";	
			} else {
				$job->job_total_assistants 			= $job->job_total_assistants + 1;
				$job->job_total_active_assistants	= $job->job_total_active_assistants + 1;
				if (!strstr(strtoupper($job->job_status), 'RECEIVED')) {
					$job->job_status = 'DISPATCHED';
				}
				$res = $job->save();
				if (!$res) {
					Log::Info('Failed to update job_total_assistants and job_total_active_assistants while dispatch task '.$job_id.'to staff '.$staff_id."!");
					return "jobDispatchOK=false";	
				} else {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Increased job_total_active_assistants for task '.$job_id.' OK.', '');
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Dispatched task '.$job_id.' to staff '.$staff_id.' OK.', '');
					Log::Info('Successfully dispatched task '.$job_id.' to staff '.$staff_id."!");
					return "jobDispatchOK=true";	
				}
			}
		} else {
			Log::Info('Failed to new a JobDispatch object for task '.$job_id.'and staff '.$staff_id."!");
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

	MyHelper::LogStaffAction(Auth::user()->id, 'To didpatch material '.$mtrl_id.' with the task '.$job_id.'.', '');
	if ($material) {
		$material->mtrl_job_id = $job_id;
		$res = $material->save();
		if (!$res) {
			Log::Info('Failed to didpatch material '.$mtrl_id.' with the task '.$job_id."!");
			return "mtrlAssociateOK=false";	
		} else {
			if ($job) {
				$job->job_total_active_materials++;
				$res2 = $job->save();
				if (!$res2) {
					Log::Info('Failed to increase job_total_active_materials for task '.$job_id." while didpatch material ".$mtrl_id."!");
					return "mtrlAssociateOK=false";	
				} else {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Increased job_total_active_materials for task '.$job_id.' OK.', '');
				}
			} else {
				Log::Info('Failed to access the task '.$job_id." while didpatching material ".$mtrl_id."!");
				return "mtrlAssociateOK=false";	
			}
			MyHelper::LogStaffActionResult(Auth::user()->id, 'didpatched material '.$mtrl_id.' with task '.$job_id.' OK.', '');
			return "mtrlAssociateOK=true";	
		}
	} else {
		Log::Info('Failed to access the material '.$mtrl_id." while didpatching it with task ".$job_id."!");
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
			$project->proj_address 		= $_POST['proj_address'];
			$project->proj_city 		= $_POST['proj_city'];
			$project->proj_province 	= $_POST['proj_province'];
			$project->proj_postcode 	= $_POST['proj_postcode'];
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

Route::get('/project_attachment_main', function () {
    return view('project_attachment_main');
})->middleware(['auth'])->name('project_attachment_main');

Route::post('/uploadfile',[ProjectAttachmentController::class, 'UploadFile'])->middleware(['auth'])->name('uploadfile'); 

Route::post('/project_attachment_remove', function (Request $request) {
	$proj_id = $_POST['atchmnt_proj_id'];
	$attachment = ProjectAttachment::where('id', $proj_id)->first();

	if ($proj_id) {
		MyHelper::LogStaffAction(Auth::user()->id, 'To remove attachment '.$attachment->id, '');
		if ($attachment) {
			$attachment->atchmnt_status = "DELETED";

			$saved = $attachment->save();
			if(!$saved) {
				MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to remove attachment '.$attachment->id, '900');
			} else {
				MyHelper::LogStaffActionResult(Auth::user()->id, 'Removed attachment '.$attachment->id.' OK.', '');
			}
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to remove an attachment, but the attachment object cannot be accessed');
			return "The attachment object cannot be accessed!";
		}
	} else {
		Log::Info('Staff '.Auth::user()->id.' tried to remove an attachment, but the post parameter cannot be accessed');
		return "The post parameter cannot be accessed!";
	}
})->middleware(['auth'])->name('project_attachment_remove');

//////////////////////////////// For Tasks ////////////////////////////////
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

Route::get('assistant_material_in_job_selected', function (Request $request) {
    return view('assistant_material_in_job_selected');
})->middleware(['auth'])->name('assistant_material_in_job_selected');

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
		Log::Info('Failed to get the JobDispatch object for task '.$job_id.' and staff '.$staff_id.' while refreshing its msg from administrator.');
	}
})->middleware(['auth'])->name('reload_page_for_job_msg_from_admin');

Route::post('reload_page_for_job_msg_from_staff', function() {
	$job_id 	= $_POST['job_id'];
	$staff_id	= $_POST['staff_id'];
	$job_dispatch = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	if ($job_dispatch) {
		return $job_dispatch->jobdsp_msg_from_staff;
	} else {
		Log::Info('Failed to get the JobDispatch object for task '.$job_id.' and staff '.$staff_id.' while refreshing its msg from staff.');
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

	Route::get('op_result_material_for_assistant', function () {
		return view('op_result_for_assistant')->withOprand('material');
	})->middleware(['auth'])->name('material_for_assistant');

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
