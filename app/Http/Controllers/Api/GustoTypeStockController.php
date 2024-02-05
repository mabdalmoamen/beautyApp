<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GustoTypeStocks;
use Illuminate\Http\Request;

class GustoTypeStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (!auth()->user()->is_admin) {

            $stocks = GustoTypeStocks::where('branch_id', '=', auth()->user()->branch_id)->with(['type_id', 'stock_id', 'unit_id'])->orderBy('type_id')->get();
        } else {
            $stocks = GustoTypeStocks::with(['type_id', 'stock_id', 'unit_id'])->orderBy('type_id')->get();
        }
        return json_encode($stocks);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->branch_id = auth()->user()->branch_id;
        GustoTypeStocks::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = GustoTypeStocks::where('id', $id)->with(['type_id', 'stock_id', 'unit_id'])->first();
        return response()->json($stock);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        GustoTypeStocks::where('id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GustoTypeStocks::where('id', $id)->delete();
    }
}
