<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Models\Type;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;
use App\Models\TypeUnits;

class CashierTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        $types = Type::with('typeStock', 'units')->where('is_deleted', false)->paginate(25);
        return json_encode($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {

        $data = array();
        if ($request->type_icon) {
            $image_url = $this->UploadImage($request->type_icon, 'backend/products/');
            $data['type_icon'] = $image_url;
        }
        $data['type_name_ar'] = $request->type_name_ar;
        $data['type_name_en'] = $request->type_name_en;
        $data['type_location'] = $request->type_location;
        $data['type_purchases_price'] = $request->type_purchases_price;
        $data['type_note'] = $request->type_note;
        $data['type_sill_price'] = $request->type_sill_price;
        $data['type_discount_value'] = $request->type_discount_value;
        $data['type_discount_percent'] = $request->type_discount_percent;
        $data['type_barcode'] = $request->type_barcode;
        $data['minimum_sill_price'] = $request->minimum_sill_price;
        $data['main_type'] = $request->main_type;
        $data['type_code'] = $request->type_code;

        $data['type_has_vat'] = $request->type_has_vat;
        $data['type_exp_date'] = $request->type_exp_date;

        $data['type_vat_value'] = $request->type_vat_value;
        $data['type_vat_percent'] = $request->type_vat_percent;

        $type_id = DB::table('types')->insertGetId($data);
        if ($request->sell_unit != null) {
            $data['sell_unit'] =  $request->sell_unit;
        }
        if ($request->type_unit != null) {
            $units = $request->type_unit;
            $selectedUnits = array();
            foreach ($units as $unit) {
                if ($unit['price'] > 0) {
                    $selectedUnits['type_id'] = $type_id;
                    $selectedUnits['price'] = $unit['price'];
                    $selectedUnits['unit_id'] = $unit['unit_id']['unit_id'];
                    $selectedUnits['no_of_unit'] = $unit['no_of_unit'];
                    $selectedUnits['deff_price'] = $unit['deff_price'];
                    $selectedUnits['barcode'] = $unit['barcode'];
                    $unit_id = DB::table('type_units')->insertGetId($selectedUnits);
                    if ($request->sell_unit === $unit['unit_id']['unit_id']) {
                        $data = DB::table('types')->where('type_id', $type_id)->update(['sell_unit' => $unit_id]);
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = Type::with('units', 'typeStock', 'sell_unit')->where('is_deleted', false)->where('type_id', $id)->first();
        return response()->json($type);
    }

    public function findTypeByBarcode($id)
    {
        $type = Type::with('units', 'typeStock', 'mainType', 'sell_unit', 'type_request')->where('is_deleted', false)->where('type_barcode', $id)->first();
        if ($type) {
            return response()->json($type);
        } else {
            $type = TypeUnits::with('type')->where('barcode', $id)->first();
            if ($type) {
                return response()->json($type->type);
            }
        }
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
        } else {
            $image_url = 'backend/products/product.png';
        }
        $data['type_name_ar'] = $request->type_name_ar;
        $data['type_name_en'] = $request->type_name_en;
        $data['type_icon'] = $image_url;
        $data['type_code'] = $request->type_code;
        $data['type_location'] = $request->type_location;
        $data['type_purchases_price'] = $request->type_purchases_price;
        $data['type_note'] = $request->type_note;
        $data['type_sill_price'] = $request->type_sill_price;
        $data['type_discount_value'] = $request->type_discount_value;
        $data['type_discount_percent'] = $request->type_discount_percent;
        $data['type_barcode'] = $request->type_barcode;
        $data['minimum_sill_price'] = $request->minimum_sill_price;
        $data['main_type'] = $request->main_type;
        $data['type_vat_value'] = $request->type_vat_value;
        $data['type_vat_percent'] = $request->type_vat_percent;
        $data['type_has_vat'] = $request->type_has_vat;
        $data['type_exp_date'] = $request->type_exp_date;
        if ($request->sell_unit != null) {
            $data['sell_unit'] = $request->sell_unit['type_unit_id'];
        }
        $data = DB::table('types')->where('type_id', $id)->update($data);
        if ($request->type_unit != null) {
            $units = $request->type_unit;
            $selectedUnits = array();
            foreach ($units as $unit) {
                if ($unit['price'] > 0) {
                    $selectedUnits['type_id'] = $id;
                    $selectedUnits['price'] = $unit['price'];
                    $selectedUnits['unit_id'] = $unit['unit_id']['unit_id'];
                    $selectedUnits['no_of_unit'] = $unit['no_of_unit'];
                    $selectedUnits['deff_price'] = $unit['deff_price'];
                    $selectedUnits['barcode'] = $unit['barcode'];
                    DB::table('type_units')->insert($selectedUnits);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('types')->where('type_id', $id)->update(['is_deleted' => true]);
    }
}
