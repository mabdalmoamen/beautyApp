<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;

class TypeStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        if (!auth()->user()->is_admin) {
            $types = DB::table('types')->where('branch_id', '=', auth()->user()->branch_id)->limit(200)->get();
        } else {
            $types = DB::table('types')->limit(200)->get();
        }
        return json_encode($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = DB::table('mixins_type_stock')->where('branch_id', '=', auth()->user()->branch_id)->where('type_stock_id', $id)->first();
        return response()->json($type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        if ($request->newphoto) {
            $image_url = $this->UploadImage($request->newphoto, 'backend/products/');
        }
        $data['type_name_ar'] = $request->type_name_ar;
        $data['type_name_en'] = $request->type_name_en;
        $data['type_icon'] = $image_url ?? '';
        $data['type_location'] = $request->type_location;
        $data['type_purchases_price'] = $request->type_purchases_price;
        $data['type_note'] = $request->type_note;
        $data['type_sill_price'] = $request->type_sill_price;
        $data['type_discount_value'] = $request->type_discount_value;
        $data['type_discount_percent'] = $request->type_discount_percent;
        $data['type_barcode'] = $request->type_barcode;
        $data['minimum_sill_price'] = $request->minimum_sill_price;
        $data['main_type'] = $request->main_type;
        $data = DB::table('types')->where('type_id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = DB::table('types')->where('type_id', $id)->first();
        $photo = $type->type_icon;
        if ($photo) {
            unlink($photo);
            DB::table('types')->where('type_id', $id)->delete();
        } else {
            DB::table('types')->where('type_id', $id)->delete();
        }
    }
}
