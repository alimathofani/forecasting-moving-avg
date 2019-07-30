<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function result()
    {
        $transaction = Transaction::get(['id', 'type', 'periode', 'total', 'added_on'])->groupBy('added_on');
        
        $periode = 3;

        foreach ($transaction as $key => $master) {
            $forecasting[$key]['forecasting'] = $this->forecastingMethod($master,$periode);
            $forecasting[$key]['master']      = $master->toArray();
        }

        // dd($forecasting);

        return view('result', compact(
            [
                'forecasting',
                'periode'
            ]
        ));
    }

    public function store(Request $request)
    {
        $dataType          = $request->type;
        $dataPeriode       = $request->periode;
        $dataTotal         = $request->total;
        $dataAdded         = time();

        for ($i=0; $i < count($dataTotal); $i++) { 
            $transaction = Transaction::create([
                'user_id'  => auth()->id(),
                'type'     => $dataType,
                'periode'  => $dataPeriode[$i],
                'total'    => $dataTotal[$i],
                'added_on' => $dataAdded,
            ]);
        }

        return back();
    }

    private function forecastingMethod($master, $periode)
    {
        $forecasting = $master;
        $dataTotal   = $forecasting->pluck('total')->toArray();
        $dataPeriode = $forecasting->pluck('periode')->toArray();
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
        array_push($dataPeriode, NULL);

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

        ];
    }

    
}
