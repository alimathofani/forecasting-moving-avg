<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Sale;

class SaleController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:setting-list', ['only' => ['index']]);
        // $this->middleware('permission:setting-show', ['only' => ['show']]);
        // $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        // $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = Item::orderBy('id','ASC')->pluck('name', 'id');
        $data = [
            'count' => 6,
            'items' => $items
        ];
    	return view('sales.index', $data);
    }

    public function store(Request $request)
    {
        $items = [];
        $update = [];
        // dd($request->all());
        for ($i=0; $i < count($request->item); $i++) { 
            if (is_null($request->sale_id[$i])){
                $items[$i]['item_id'] = $request->item[$i];
                $items[$i]['price'] = $request->price[$i];
                $items[$i]['qty'] = $request->qty[$i];
                $items[$i]['total'] = $request->total[$i];
                $items[$i]['date'] = $request->date;
            }else{
                $update[$i]['id'] = $request->sale_id[$i];
                $update[$i]['item_id'] = $request->item[$i];
                $update[$i]['price'] = $request->price[$i];
                $update[$i]['qty'] = $request->qty[$i];
                $update[$i]['total'] = $request->total[$i];
                $update[$i]['date'] = $request->date;
            }
        }
        if(count($update)){
            foreach ($update as $value) {
                $sale = Sale::find($value['id']);
                $sale->item_id = $value['item_id'];
                $sale->price = $value['price'];
                $sale->qty = $value['qty'];
                $sale->total = $value['total'];
                $sale->date = $value['date'];
                $sale->save();
            }
        }
        if(count($items)){
            Sale::insert($items);
        }

    	return back()->with('success','Nota Created!');;
    }

    public function calculate(Request $request)
    {
        $date = explode(" ", $request->date);
        $item_id = $request->item;
        if(count($date) == 2){
            $month = date('m', strtotime($date[0]));
            $year = $date[1];
            $result = Sale::where('item_id', $item_id)->whereMonth('date', $month)->whereYear('date', $date[1])->get();
            $totalQty = $result->sum('qty');
        } else if (count($date) == 1){
            $year = $date[0];
            $result = Sale::where('item_id', $item_id)->whereYear('date', $date[0])->get();
            $totalQty = $result->sum('qty');
        }else{
            $totalQty = 0;
        }
        
        $data = [
            'total' => $totalQty
        ];

        return response()->json($data, 200);
    }

    public function data(Request $request)
    {
        $date = $request->date;
        $result = Sale::where('date', $date)->with('item')->get();
        $data = $result;
        return response()->json($data, 200);
    }
}
