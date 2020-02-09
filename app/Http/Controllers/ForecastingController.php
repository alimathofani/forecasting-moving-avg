<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Setting;
use App\Template;
use DateTime;

class ForecastingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:forecasting-create', ['only' => ['index','store']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('sales')) {
            return redirect()->route('result.index');
        }
        $items = Item::orderBy('id', 'ASC')->pluck('name','id');
        
        $setDivider = Setting::dividerActive()->value('id');

        return view('forecasting', compact([
            'items',
            'setDivider'
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'periode' => 'required'
        ]);

        $dataType          = $request->type;
        $dataName          = time();
        $dataPeriode       = $request->periode;
        $dataTotal         = $request->total;
        $dataItem          = $request->item_id;
        $dataDivider       = 3;
        
        $settingDiv = Setting::where('name', 'forecasting-divider')->value('id');

        $template = Template::create([
            'user_id' => auth()->id(),
            'item_id' => $dataItem,
            'name' => $dataName
        ]);

        $template->settings()->attach($settingDiv, ['value' => $dataDivider]);
        
        for ($i=0; $i < count($dataTotal); $i++) { 
            if (is_null($dataPeriode[$i])) {
                return back()->with('error','Semua Input Harus Terisi');
            }

            if ($dataType == "Bulan") {
                $periode = new DateTime($dataPeriode[$i]);
            }else{
                $periode = new DateTime('01-01-'.$dataPeriode[$i]);
            }

            $template->transactions()->create([
                'type'     => $dataType,
                'periode'  => $periode,
                'total'    => $dataTotal[$i]
            ]);
        }

        return back()->with('success','Forecasting Moving Average Created!');
    }    
}
