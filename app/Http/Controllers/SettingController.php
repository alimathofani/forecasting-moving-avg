<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $settings = Setting::where('user_id', auth()->id())->where('status', true)->get();
    	return view('setting.index', compact('settings'))->with('i', '0');
    }

    public function generate(Request $request)
    {
    	Setting::create([
            'user_id' => auth()->id(),
            'name' => 'periodDivider',
            'value' => 10
        ]);

        Setting::create([
            'user_id' => auth()->id(),
            'name' => 'typeDivider',
            'value' => 'month',
            'status' => false
        ]);

    	return back()->with('success','Generated!');;
    }

    public function edit(Setting $setting)
    {
    	return view('setting.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->request->add(['user_id' => auth()->id()]);

    	$setting->update($request->all());

    	 return redirect()->route('settings.index')
                        ->with('success','Updated!');

    }

    // public function destroy(Item $item)
    // {
    // 	$item->delete();

    // 	return redirect()->route('items.index')
    //                     ->with('success','Deleted!');
    // }
}
