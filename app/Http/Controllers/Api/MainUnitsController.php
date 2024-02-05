<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupllierRequest;
use App\Models\MixinsSuppliers;
use App\Models\TypeUnits;
use App\Models\Unit;
use Illuminate\Http\Request;
use DB;

class MainUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->branch->same_type) {
            $units = Unit::get()->all();
        } else {
            $units = Unit::where('branch_id', '=', auth()->user()->branch_id)->get()->all();
        }
        return  json_encode($units);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Unit::insert($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::where('unit_id', $id)->first();
        return response()->json($unit);
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

        Unit::where('unit_id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Unit::where('unit_id', $id)->delete();
    }
}
