<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Project;
use App\Models\Material;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'mtrl_name'   => 'required',
                'mtrl_type'   => 'required',
                'mtrl_model'  => 'required',
                'mtrl_amount' => 'required',
            ]);

            $material = new Material;
            $job = Job::where('job_name', $request->job_name)->first();

            MyHelper::LogStaffAction(Auth::user()->id, 'Added material of type '.$request->mtrl_type.' (model= '.$request->mtrl_model.') for job '.$request->job_name.'.', '');
    
            if ($material) {
                if ($job) {
                    $material->mtrl_job_id      = $job->id;
                }
                $material->mtrl_name        = $request->mtrl_name;
                $material->mtrl_model       = $request->mtrl_model;
                $material->mtrl_status      = "CREATED";
                $material->mtrl_type        = $request->mtrl_type;
                // if ($request->mtrl_type != "INSULATION") {
                    $material->mtrl_size        = $request->mtrl_size;
                    $material->mtrl_size_unit   = $request->mtrl_size_unit;
                // }
                $material->mtrl_source      = $request->mtrl_source;
                $material->mtrl_shipped_by  = $request->mtrl_shipped_by;
                $material->mtrl_amount      = $request->mtrl_amount;
                $material->mtrl_amount_unit = $request->mtrl_amount_unit;
                $material->mtrl_amount_left = $request->mtrl_amount;
                $material->mtrl_unit_price  = $request->mtrl_unit_price;
                $material->mtrl_total_price = $request->mtrl_total_price;
                $material->mtrl_notes       = $request->mtrl_notes;
                $saved = $material->save();
            } else {
                $err_msg = "Material object cannot be accessed while adding a new material.";
                Log::Info($err_msg." / ".$request->job_name);
                return "Something wrong while adding the new material.";
            }
            
            if(!$saved) {
                $err_msg = "Material ".$request->mtrl_type." cannot be added.";
                Log::Info($err_msg);
                return redirect()->route('op_result.material', ['backTo'=>$request->back_to])->with('status', ' <span style="color:red">Material Has NOT Been inserted!</span>');
            } else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Added material OK.', '');
                return redirect()->route('op_result.material', ['backTo'=>$request->back_to])->with('status', 'The new material of type <span style="font-weight:bold;font-style:italic;color:blue">'.$request->mtrl_type.'</span>, has been inserted successfully.');
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
                'mtrl_type'   => 'required',
                'mtrl_model'  => 'required',
                'mtrl_amount' => 'required',
            ]);

            MyHelper::LogStaffAction(Auth::user()->id, 'Updated material of ID '.$request->mtrl_id.' (model= '.$request->mtrl_model.').', '');
            
            $material = Material::where('id', $request->mtrl_id)->first();
            $job = Job::where('job_name', $request->job_name)->first();
    
            if ($material) {
                // if ($request->job_name == "") {
                //     $material->mtrl_job_id      = 0;
                // } else {
                //     if ($job) {
                //         $material->mtrl_job_id  = $job->id;
                //     } else {
                //         MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to access job object for job '.$request->job_name.' while update material '.$request->mtrl_id, '900');
                //     }
                // }
                if ($material->mtrl_name != $request->mtrl_name) {
                    Log::Info(Auth::user()->id.' will update mtrl_name from '.$material->mtrl_name.' to '.$request->mtrl_name.' for material ID= '.$material->id);
                }
                $material->mtrl_name        = $request->mtrl_name;
                // $material->mtrl_status      = $request->mtrl_status;
                if ($material->mtrl_model != $request->mtrl_model) {
                    Log::Info(Auth::user()->id.' will update mtrl_model from '.$material->mtrl_model.' to '.$request->mtrl_model.' for material ID= '.$material->id);
                }
                $material->mtrl_model       = $request->mtrl_model;
                if ($material->mtrl_type != $request->mtrl_type) {
                    Log::Info(Auth::user()->id.' will update mtrl_type from '.$material->mtrl_type.' to '.$request->mtrl_type.' for material ID= '.$material->id);
                }
                $material->mtrl_type        = $request->mtrl_type;
                if ($material->mtrl_size != $request->mtrl_size) {
                    Log::Info(Auth::user()->id.' will update mtrl_size from '.$material->mtrl_size.' to '.$request->mtrl_size.' for material ID= '.$material->id);
                }
                $material->mtrl_size        = $request->mtrl_size;
                if ($material->mtrl_size_unit != $request->mtrl_size_unit) {
                    Log::Info(Auth::user()->id.' will update mtrl_size_unit from '.$material->mtrl_size_unit.' to '.$request->mtrl_size_unit.' for material ID= '.$material->id);
                }
                $material->mtrl_size_unit   = $request->mtrl_size_unit;
                if ($material->mtrl_source != $request->mtrl_source) {
                    Log::Info(Auth::user()->id.' will update mtrl_source from '.$material->mtrl_source.' to '.$request->mtrl_source.' for material ID= '.$material->id);
                }
                $material->mtrl_source      = $request->mtrl_source;
                if ($material->mtrl_shipped_by != $request->mtrl_shipped_by) {
                    Log::Info(Auth::user()->id.' will update mtrl_shipped_by from '.$material->mtrl_shipped_by.' to '.$request->mtrl_shipped_by.' for material ID= '.$material->id);
                }
                $material->mtrl_shipped_by  = $request->mtrl_shipped_by;
                if ($material->mtrl_amount != $request->mtrl_amount) {
                    Log::Info(Auth::user()->id.' will update mtrl_amount from '.$material->mtrl_amount.' to '.$request->mtrl_amount.' for material ID= '.$material->id);
                }
                $material->mtrl_amount      = $request->mtrl_amount;
                if ($material->mtrl_amount_unit != $request->mtrl_amount_unit) {
                    Log::Info(Auth::user()->id.' will update mtrl_amount_unit from '.$material->mtrl_amount_unit.' to '.$request->mtrl_amount_unit.' for material ID= '.$material->id);
                }
                $material->mtrl_amount_unit = $request->mtrl_amount_unit;
                if ($material->mtrl_amount_left != $request->mtrl_amount_left) {
                    Log::Info(Auth::user()->id.' will update mtrl_amount_left from '.$material->mtrl_amount_left.' to '.$request->mtrl_amount_left.' for material ID= '.$material->id);
                }
                $material->mtrl_amount_left = $request->mtrl_amount_left;
                if ($material->mtrl_unit_price != $request->mtrl_unit_price) {
                    Log::Info(Auth::user()->id.' will update mtrl_unit_price from '.$material->mtrl_unit_price.' to '.$request->mtrl_unit_price.' for material ID= '.$material->id);
                }
                $material->mtrl_unit_price  = $request->mtrl_unit_price;
                if ($material->mtrl_total_price != $request->mtrl_total_price) {
                    Log::Info(Auth::user()->id.' will update mtrl_total_price from '.$material->mtrl_total_price.' to '.$request->mtrl_total_price.' for material ID= '.$material->id);
                }
                $material->mtrl_total_price = $request->mtrl_total_price;
                if ($material->mtrl_notes != $request->mtrl_notes) {
                    Log::Info(Auth::user()->id.' will update mtrl_notes from '.$material->mtrl_notes.' to '.$request->mtrl_notes.' for material ID= '.$material->id);
                }
               $material->mtrl_notes       = $request->mtrl_notes;
                $saved = $material->save();
            } else {
                $err_msg = "Material cannot be accessed while updating a material.";
                Log::Info($err_msg." / ".$request->job_name);
                return "Something wrong while updating the material.";
            }
            
            if(!$saved) {
                $err_msg = "Material ".$request->mtrl_type." cannot be updated.";
                Log::Info($err_msg);
                return redirect()->route('op_result.material')->with('status', ' <span style="color:red">Material Has NOT Been updated!</span>');
            } else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated material '.$material->id.' OK.', '');
                if (Auth::user()->role == 'ADMINISTRATOR') {
                    return redirect()->route('op_result.material')->with('status', 'The material of type <span style="font-weight:bold;font-style:italic;color:blue">'.$request->mtrl_type.'</span>, has been updated successfully.');
                } else {
                    return redirect()->route('op_result.material_for_assistant')->with('status', 'The material of type <span style="font-weight:bold;font-style:italic;color:blue">'.$request->mtrl_type.'</span>, has been updated successfully.');
                }
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted material of ID '.$id, '');

            $material = Material::where('id', $id)->first();
            if ($material) {
                $material->mtrl_status    = "DELETED";
                $materialType = $material->mtrl_type;
                $res = $material->save();
                if (!$res) {
                    $err_msg = "Material ".$id." cannot be deleted.";
                    Log::Info($err_msg);
                    return redirect()->route('op_result.material')->with('status', 'The material of type <span style="font-weight:bold;font-style:italic;color:red">'.$materialType.'</span>, cannot be deleted for some reason.');	
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted material '.$id.' OK.', '');
                    return redirect()->route('op_result.material')->with('status', 'The material of type <span style="font-weight:bold;font-style:italic;color:blue">'.$materialType.'</span>, has been deleted successfully.');	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a material, but the material '.$id.' object cannot be accessed');
                return redirect()->route('op_result.material')->with('status', ' <span style="color:red">The material object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
