<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list', ['only' => ['index']]);
        $this->middleware('permission:setting-show', ['only' => ['show']]);
        $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $settings = Setting::all();
    	return view('setting.index', compact('settings'))->with('i', '0');
    }

    public function edit(Setting $setting)
    {
    	return view('setting.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $status = $request->status;

        if($status){
            $setting->status = true;
        }else{
            $setting->status = false;
        }
        
    	$setting->save();

    	 return redirect()->route('settings.index')
                        ->with('success','Updated!');

    }
}
