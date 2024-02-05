<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Models\BillTypes;
use App\Models\Mixins;
use App\Models\Type;
use App\Traits\ImagesTrait;
use Illuminate\Http\Request;
use DB;
use App\Models\TypeUnits;
use Carbon\Carbon;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        if (auth()->user()->branch->same_type) {

            $types = Type::with('typeStock', 'units')->where('is_deleted', false)->get();
        } else {
            $types = Type::with('typeStock', 'units')->where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->get();
        }
        return json_encode($types);
    }
    public function TypesReport($period, $from, $to, $typeId)
    {

        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if ($typeId != "null") {
            if ($period == "daily") {
                $time =
                    $today;
                $bills = BillTypes::where('type_id', $typeId)->with(['type', 'units', 'bill' => function ($q) use ($today) {
                    return $q->where('bill_date', '>=',  $today);
                }])->orderBy('bill_no', 'DESC');
            } else if ($period == "monthly") {

                $bills = BillTypes::where('type_id', $typeId)->with(['type', 'units', 'bill' => function ($q) {
                    return $q->whereMonth('bill_date', date('m'));
                }])->orderBy('bill_no', 'DESC');
            } else {
                if ($from && $to)
                    $bills = BillTypes::where('type_id', $typeId)->with(['type', 'units', 'bill' => function ($q) use ($from, $to) {
                        return $q->whereDate('bill_date', '>=', $from)
                            ->whereDate('bill_date', '<=', $to);
                    }])->orderBy('bill_no', 'DESC');
            }
        } else {
            if ($period == "daily") {
                $time =
                    $today;
                $bills = BillTypes::with(['type', 'units', 'bill' => function ($q) use ($today) {
                    return $q->where('bill_date', '>=',  $today);
                }])->orderBy('bill_no', 'DESC');
            } else if ($period == "monthly") {
                $bills = BillTypes::with(['type', 'units', 'bill' => function ($q) {
                    return $q->whereMonth('bill_date', date('m'));
                }])->orderBy('bill_no', 'DESC');
            } else {
                if ($from && $to)
                    $bills = BillTypes::with(['type', 'units', 'bill' => function ($q) use ($from, $to) {
                        return $q->whereDate('bill_date', '>=', $from)
                            ->whereDate('bill_date', '<=', $to);
                    }])->orderBy('bill_no', 'DESC');
            }
        }
        $data
            = array();
        $data['bills'] = $bills->get();
        $data['sill_price'] = $bills->sum('type_total_price');
        $data['purchases_price'] = $bills->sum('type_purchases_price');

        return response()->json($data);
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
        } else {
            $image_url = 'backend/products/product.png';
        }
        $data['type_name_ar'] = $request->type_name_ar;
        $data['type_name_en'] = $request->type_name_en;
        $data['type_icon'] = $image_url;
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
        $data['branch_id'] = auth()->user()->branch_id;

        $data['type_has_vat'] = $request->type_has_vat;
        $data['type_exp_date'] = $request->type_exp_date;

        $data['type_vat_value'] = $request->type_vat_value;
        $data['type_vat_percent'] = $request->type_vat_percent;
        if ($request->sell_unit != null) {
            $data['sell_unit'] =  $request->sell_unit;
        }
        $type_id = DB::table('types')->insertGetId($data);
        if ($request->type_unit != null) {
            $units = $request->type_unit;
            $selectedUnits = array();
            foreach ($units as $unit) {
                if ($unit['price'] >= 0) {
                    $selectedUnits['type_id'] = $type_id;
                    $selectedUnits['price'] = $unit['price'];
                    $selectedUnits['unit_id'] = $unit['unit_id']['unit_id'];
                    $selectedUnits['no_of_unit'] = $unit['no_of_unit'];
                    $selectedUnits['deff_price'] = $unit['deff_price'];
                    $selectedUnits['barcode'] = $unit['barcode'];
                    $selectedUnits['branch_id'] = auth()->user()->branch_id;

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
                if ($unit['price'] >= 0) {
                    $selectedUnits['type_id'] = $id;
                    $selectedUnits['price'] = $unit['price'];
                    $selectedUnits['unit_id'] = $unit['unit_id']['unit_id'];
                    $selectedUnits['no_of_unit'] = $unit['no_of_unit'];
                    $selectedUnits['deff_price'] = $unit['deff_price'];
                    $selectedUnits['barcode'] = $unit['barcode'];
                    DB::table('type_units')->insertGetId($selectedUnits);
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

        $type = BillTypes::where('type_id', $id)->first();
        if (!$type) {
            $delete = Type::where('type_id', $id)->delete();
        } else {
            DB::table('types')->where('type_id', $id)->update(['is_deleted' => true]);
        }
    }
    public function massDestroy($types)
    {
        $typesArray = explode(',', $types);
        Type::whereKey($typesArray)->update(['is_deleted' => true]);
        return $typesArray;
    }
}
