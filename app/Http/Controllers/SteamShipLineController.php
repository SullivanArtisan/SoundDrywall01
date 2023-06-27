<?php

namespace App\Http\Controllers;

use App\Models\SteamShipLine;
use Illuminate\Http\Request;

class SteamShipLineController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ssl_name'  => 'required|unique:steam_ship_lines',
        ]);
        
        $ssl = new SteamShipLine;
        $ssl->ssl_name          = $request->ssl_name;
        $ssl->ssl_description   = $request->ssl_description;
        $saved = $ssl->save();
        
        if(!$saved) {
            return redirect()->route('op_result.ssl')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
        } else {
            return redirect()->route('op_result.ssl')->with('status', 'The steamship line <span style="font-weight:bold;font-style:italic;color:blue">'.$ssl->ssl_name.'</span>, has been inserted successfully.');
        }
    }
	
    public function update(Request $request)
    {
        $validated = $request->validate([
            'ssl_name'  => 'required',
        ]);
        
        $ssl = SteamShipLine::where('id', $request->id)->first();
        $ssl->ssl_name          = $request->ssl_name;
        $ssl->ssl_description   = $request->ssl_description;
        $saved = $ssl->save();
        
        if(!$saved) {
            return redirect()->route('op_result.ssl')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
        } else {
            return redirect()->route('op_result.ssl')->with('status', 'The steamship line,  <span style="font-weight:bold;font-style:italic;color:blue">'.$ssl->ssl_name.'</span>, has been updated successfully.');
        }
    }
}
