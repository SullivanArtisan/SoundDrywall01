<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cmpny_name'        => 'required|unique:companies',
            'cmpny_address'     => 'required',
            'cmpny_city'        => 'required',
            'cmpny_province'    => 'required',
            'cmpny_postcode'    => 'required',
        ]);
        
        $company = new Company;
        $company->cmpny_name        = $request->cmpny_name;
        $company->cmpny_address     = $request->cmpny_address;
        $company->cmpny_city        = $request->cmpny_city;
        $company->cmpny_province    = $request->cmpny_province;
        $company->cmpny_postcode    = $request->cmpny_postcode;
        $company->cmpny_country     = $request->cmpny_country;
        $company->cmpny_zone        = $request->cmpny_zone;
        $company->cmpny_contact     = $request->cmpny_contact;
        $company->cmpny_tel         = $request->cmpny_tel;
        $company->cmpny_email       = $request->cmpny_email;
        $company->cmpny_chassis_capability  = $request->cmpny_chassis_capability;
        $company->cmpny_driver_notes        = $request->cmpny_driver_notes;
        $saved = $company->save();
        
        if(!$saved) {
            return redirect()->route('op_result.company')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
        } else {
            return redirect()->route('op_result.company')->with('status', 'The steamship line <span style="font-weight:bold;font-style:italic;color:blue">'.$company->cmpny_name.'</span>, has been inserted successfully.');
        }
    }
	
    public function update(Request $request)
    {
        $validated = $request->validate([
            'cmpny_name'        => 'required',
            'cmpny_address'     => 'required',
            'cmpny_city'        => 'required',
            'cmpny_province'    => 'required',
            'cmpny_postcode'    => 'required',
        ]);
        
        $company = Company::where('id', $request->id)->first();
        $company->cmpny_name        = $request->cmpny_name;
        $company->cmpny_address     = $request->cmpny_address;
        $company->cmpny_city        = $request->cmpny_city;
        $company->cmpny_province    = $request->cmpny_province;
        $company->cmpny_postcode    = $request->cmpny_postcode;
        $company->cmpny_country     = $request->cmpny_country;
        $company->cmpny_zone        = $request->cmpny_zone;
        $company->cmpny_contact     = $request->cmpny_contact;
        $company->cmpny_tel         = $request->cmpny_tel;
        $company->cmpny_email       = $request->cmpny_email;
        $company->cmpny_chassis_capability  = $request->cmpny_chassis_capability;
        $company->cmpny_driver_notes        = $request->cmpny_driver_notes;
        $saved = $company->save();
        
        if(!$saved) {
            return redirect()->route('op_result.company')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
        } else {
            return redirect()->route('op_result.company')->with('status', 'The company,  <span style="font-weight:bold;font-style:italic;color:blue">'.$company->cmpny_name.'</span>, has been updated successfully.');
        }
    }
}
