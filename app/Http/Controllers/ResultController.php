<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use App\Setting;

class ResultController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:forecasting-list', ['only' => ['index', 'list']]);
        $this->middleware('permission:forecasting-show', ['only' => ['show']]);
        $this->middleware('permission:forecasting-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('result');
    }
    
    public function list()
    {
        if (auth()->user()->hasRole('owner','admin')) {
            $template = Template::with('transactions', 'item')->get();
        }else{
            $template = Template::where('confirm', 1)->with('transactions', 'item')->get();
        }
        
        if (!$template->count()) {
            return response()->json([
                'data' => false
            ]);
        }
        
        $i = 0;
        foreach ($template as $data) {
            $setDivider = $data->set_div;
            $item = $data->item->name;
            $transactions = $data->transactions;
            $forecasting[$i]['id'] = $data->id;
            $forecasting[$i]['name'] = $data->name;
            $forecasting[$i]['forecasting'] = $this->forecastingMethod($transactions,$setDivider);
            $forecasting[$i]['item']        = $item;
            $forecasting[$i]['divider']     = $setDivider;
            $forecasting[$i]['status']['id']     = $data->id;
            $forecasting[$i]['status']['user_id']     = $data->user_id;
            $forecasting[$i]['status']['confirm']     = $data->confirm;
            $i++;
        }

        return response()->json([
            'data' => $forecasting,
        ]);
    }

    public function show(Request $request)
    {
        $template = Template::where('id', $request->id)->with('transactions', 'item')->first();
        $transactions = $template->transactions;
        
        if (!$transactions->count()) {
            return response()->json([
                'data' => false,
            ]);
        }
        
        $setDivider = $template->set_div;
        $item = $template->item->name;
        $forecasting['id'] = $template->id;
        $forecasting['forecasting'] = $this->forecastingMethod($transactions,$setDivider);
        $forecasting['master']      = $transactions->toArray();
        $forecasting['item']        = $item;

        return response()->json([
            'data' => $forecasting,
            'periode' => $setDivider
        ]);

    }

    public function delete($id)
    {
        if (auth()->user()->hasRole('owner','admin')) {
            $template = Template::with('transactions')->find($id);
        }else{
            $template = Template::with('transactions')->where('user_id', auth()->id())->find($id);
        }

        $transactions = $template->transactions;
        
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        $template->settings()->detach();
        $template->delete();

        return back()->with('success', 'DELETED !');
    }

    public function confirm(Request $request, $id)
    {
        if (auth()->user()->hasRole('owner','admin')) {
            $template = Template::with('transactions')->find($id);
        }else{
            $template = Template::with('transactions')->where('user_id', auth()->id())->find($id);
        }

        if (!$template->count()) {
            return back()->with('error', 'Not Found !');
        }
        
        $template->confirm = 1;
        $template->save();

        return back()->with('success', 'Confirmed !');
    }
    
    protected function forecastingMethod($master, $periode)
    {
        $forecasting = $master;
        $dataTotal   = $forecasting->pluck('total')->toArray();
        $dataPeriode = $forecasting->pluck('periode')->toArray();
        $dataType = $forecasting->pluck('type')->first();
        $count       = count($dataTotal);

        $x = 1;

        for ($i=0; $i < $count ; $i++) { 
            
            $slice[$x] = array_slice($dataTotal, $i, $periode);
            $ema[$x]   = array_sum($slice[$x]) / $periode;

            if (count($slice[$x]) < $periode) {
                unset($slice[$x]);
                unset($ema[$x]);
            }

            $x++;
        }

        for ($i=0; $i < $periode ; $i++) { 
            array_unshift($ema, NULL);
        }
        
        $resultTotal = $dataTotal;
        array_push($resultTotal, NULL);
        if ($dataType == "Bulan") {
            $lastDate = date("Y-m-d H:i:s", strtotime(end($dataPeriode)));
            $addMonth = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($lastDate)));
            array_push($dataPeriode, $addMonth);

        }elseif($dataType == "Tahun"){
            $lastDate = date("Y-m-d H:i:s", strtotime(end($dataPeriode)));
            $addYear = date('Y-m-d H:i:s', strtotime("+1 years", strtotime($lastDate)));
            array_push($dataPeriode, $addYear);
        }else{
            array_push($dataPeriode, NULL);
        }

        $dataFinal = [];
        $dataAverage = [];

        $totalAbs = 0;
        $totalSquared = 0;
        $totalAbsPercent = 0;
        
        for ($i=0; $i < count($resultTotal); $i++) { 
            $totalRow       = $resultTotal[$i];
            $emaRow         = $ema[$i];
            $actualRow      = $emaRow ? $totalRow - $emaRow : '';
            $absRow         = $emaRow ? abs($actualRow) : '';
            $squaredRow     = $emaRow ? pow($absRow,2) : '';
            $abs_percentRow = ($emaRow && $totalRow) ? $absRow / $totalRow  * 100 / 100 : '';

            $dataFinal[$i]['periode']     =  $dataPeriode[$i];
            $dataFinal[$i]['total']       =  $totalRow;
            $dataFinal[$i]['ema']         = $emaRow;
            $dataFinal[$i]['actual']      = $actualRow;
            $dataFinal[$i]['abs']         = $absRow;
            $dataFinal[$i]['squared']     = $squaredRow;
            $dataFinal[$i]['abs_percent'] = $abs_percentRow;

            if (is_numeric($absRow)) {
                $totalAbs += $absRow;
            }

            if (is_numeric($squaredRow)) {
                $totalSquared += $squaredRow;
            }

            if (is_numeric($abs_percentRow)) {
                $totalAbsPercent += $abs_percentRow;
            }
        }
        
        $countEma = count(array_filter($dataFinal, function($data) { return !empty($data['ema']); }));
        
        if ($countEma) {
            $dataAverage['averageAbs']['value'] = $totalAbs/$countEma;
            $dataAverage['averageSquared']['value'] = $totalSquared/$countEma;
            $dataAverage['averageAbsPercent']['value'] = $totalAbsPercent/$countEma;
        }

        return [
            'dataFinal' => $dataFinal,
            'dataAverage' => $dataAverage,
            'resultTotal' => $resultTotal,
            'ema' => $ema,
            'ema_end' => end($ema)

        ];
    }
}
