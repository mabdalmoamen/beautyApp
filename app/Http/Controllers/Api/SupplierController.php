<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupllierRequest;
use App\Models\MixinsSuppliers;
use Illuminate\Http\Request;
use DB;

class SupplierController extends Controller
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
            $suppliers = MixinsSuppliers::where('branch_id', '=', auth()->user()->branch_id)->get();
        } else {
            $suppliers = MixinsSuppliers::get();
        }

        return  json_encode($suppliers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupllierRequest $request)
    {

        DB::table('mixins_suppliers')->insert($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = DB::table('mixins_suppliers')->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_id', $id)->first();
        if (!$supplier)
            $supplier = DB::table('mixins_suppliers')->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_name', $id)->first();
        if (!$supplier)
            $supplier = DB::table('mixins_suppliers')->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_mobile', $id)->first();
        return response()->json($supplier);
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
        DB::table('mixins_suppliers')->where('supplier_id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('mixins_suppliers')->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_id', $id)->first();

        DB::table('mixins_suppliers')->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_id', $id)->delete();
    }
}
