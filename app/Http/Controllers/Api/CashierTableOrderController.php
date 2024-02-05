<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\TableBill;
use Illuminate\Http\Request;
use DB;

class CashierTableOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(TableBill::where('branch_id', '=', auth()->user()->branch_id)->with(['tableType', 'table','customer', 'user'])->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $bill = array();
        $bill['bill_sum'] = $request->sum;
        $bill['bill_extra'] = $request->extra ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['bill_notes'] = $request->note;
        $bill['branch_id'] = auth()->user()->branch_id;

        $bill['cust_id'] = $request->customer['cust_id'] ?? null;
        $bill_no = DB::table('tables_bill')->insertGetId($bill);
        $this->insertBilltypes($request->cart, $bill_no);
        return response($bill_no);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $bill = TableBill::where('branch_id', '=', auth()->user()->branch_id)->with(['tableType', 'customer', 'user'])->where('id', $id)->first();
        return response()->json($bill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tables_bill')->where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->delete();
    }
    protected function insertBilltypes($contents, $bill_no)
    {
        $billdetails = array();
        foreach ($contents as $content) {
            $billdetails['table_bill_id'] = $bill_no;
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['sell_unit'] = $content['sell_unit']?$content['sell_unit']['type_unit_id']:null;
            $billdetails['type_price'] = $content['type_sill_price'];
            $billdetails['type_total_price'] = $content['total_type_cost'];
            $billdetails['type_note'] = $content['type_note'];
            DB::table('table_types')->insert($billdetails);
        }
    }
}
