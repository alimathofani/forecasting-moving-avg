<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
    	$items = Item::where('user_id', auth()->id() )->orderBy('id','ASC')->get();
    	return view('items.index', compact('items'))->with('i', '0');
    }

    public function store(Request $request)
    {
    	$request->validate([
            'name' => 'required',
        ]);

    	Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
    	]);

    	return back()->with('success','Master Barang Created!');;
    }

    public function edit(Item $item)
    {
    	return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
    	$request->validate([
    	            'name' => 'required',
                ]);

        $request->request->add(['user_id' => auth()->id()]);

    	$item->update($request->all());

    	 return redirect()->route('items.index')
                        ->with('success','Updated!');

    }

    public function destroy(Item $item)
    {
    	$item->delete();

    	return redirect()->route('items.index')
                        ->with('success','Deleted!');
    }
}
