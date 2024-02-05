<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\CustomerPay;
use App\Models\MixinsItemRequest;
use App\Models\MixinsMainTypes;
use App\Models\Offer;
use App\Models\PayMethods;
use App\Models\Returns;
use App\Models\Type;
use App\Models\Mixins;
use App\Models\TableBill;
use App\Models\TypeUnits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ActionController extends Controller
{

    public function getCookie(Request $request)
    {
        $value = $request->cookie('locale');
        echo $value;
    }
    public function resetFunc($tables)
    {
        $tags = explode(',', $tables);
        Schema::disableForeignKeyConstraints();
        foreach ($tags as $table) {
            if ($table != 'users') {
                DB::table($table)->truncate();
            } else {
                Db::table($table)->where('id', '>=', 1)->delete();
            }
            DB::statement('ALTER TABLE ' . $table . ' AUTO_INCREMENT = 1;');
        }
        Schema::enableForeignKeyConstraints();
    }



    public function getAllCategories()
    {
        if (auth()->user()->branch->same_type) {
            $mainTypes = MixinsMainTypes::with(['products' => function ($q) {
                $q->where('is_deleted', false);
            }])->get();
            return json_encode($mainTypes);
        } else {
            $mainTypes = MixinsMainTypes::where('branch_id', '=', auth()->user()->branch_id)->with(['products' => function ($q) {
                $q->where('is_deleted', false);
            }])->get();
            return json_encode($mainTypes);
        }
    }
    public function findCustomers()
    {
        $customers = Customer::where('branch_id', '=', auth()->user()->branch_id)->get()->all();
        return  response()->json($customers);
    }
    public function addToSoldWithoutStock($id, $count)
    {
        $typeStock = DB::table('types_sold_without_balance')->where('branch_id', '=', auth()->user()->branch_id)->where('type_id', $id);
        if ($typeStock) {
            $typeStock->update(['qty' => DB::raw('qty +' . $count)]);
        } else {
            $typeStock = array();
            $typeStock['type_id'] = $id;
            $typeStock['branch_id'] = auth()->user()->branch_id;
            DB::table('types_sold_without_balance')->insert($typeStock);
        }
    }
    public function payBill($id, $pay)
    {
        $bill = Bill::where('is_deleted', false)->where('branch_id', '=', auth()->user()->branch_id)->where('bill_no', $id)->first();
        $bill->where('bill_no', $id)->update(['bill_paid_type' => $pay]);
    }

    public function checkIfTypeAddedToItemRequestToday($id)
    {
        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $typeStock = DB::table('mixins_item_request')->where('branch_id', '=', auth()->user()->branch_id)->where('type_request', $id)->where('added_request_date', '>=', $today)->first();
        if ($typeStock)
            return response()->json(true);
        return response()->json(false);
    }

    public function addToExitStock($id)
    {
        $typeStock = DB::table('mixins_item_request')->where('branch_id', '=', auth()->user()->branch_id)->where('type_request', $id)->first();
        if ($typeStock) {
            DB::table('mixins_item_request')->where('branch_id', '=', auth()->user()->branch_id)->where('type_request', $id)->update(['added_request_date' => now()]);
        } else {
            $typeStock = array();
            $typeStock['type_request'] = $id;
            $typeStock['added_request_date'] = now();
            $typeStock['branch_id'] =
                auth()->user()->branch_id;

            DB::table('mixins_item_request')->insert($typeStock);
        }
    }

    public function findTypeByCodeOrId($id)
    {
        if (auth()->user()->branch->same_type) {

            $type = Type::where('type_id', $id)->where('is_deleted', false)->with('typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers')->first();
            if (!$type)
                $type = Type::where('type_code', $id)->where('is_deleted', false)->with('typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers')->first();

            return response()->json($type);
        } else {
            $type = Type::where('type_id', $id)->where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with('typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers')->first();
            if (!$type)
                $type = Type::where('type_code', $id)->where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with('typeStock', 'mainType', 'units',  'sell_unit', 'type_request', 'offers')->first();

            return response()->json($type);
        }
    }
    public function  lastId()
    {
        $type = Type::select('type_id')->orderByDesc('type_id')->first();

        return response()->json($type->type_id);
    }
    public function findTypeByLike($name)
    {
        if (auth()->user()->branch->same_type) {

            $type = Type::with('units', 'typeStock', 'mainType', 'sell_unit')->where('is_deleted', false)->where('type_name_ar', 'like', '%' . $name . '%')->orwhere('type_name_en', 'like', '%' . $name . '%')->get()->all();
            return response()->json($type);
        } else {
            $type = Type::with('units', 'typeStock', 'mainType', 'sell_unit')->where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('type_name_ar', 'like', '%' . $name . '%')->orwhere('type_name_en', 'like', '%' . $name . '%')->get()->all();
            return response()->json($type);
        }
    }

    public function supplierPay($id, $pay)
    {
        DB::table('mixins_suppliers')
            ->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_id', $id)
            ->update(['supplier_total_paid' => DB::raw('supplier_total_paid +' . $pay)]);
        DB::table('mixins_suppliers')
            ->where('branch_id', '=', auth()->user()->branch_id)->where('supplier_id', $id)->update(['supplier_total_remain' => DB::raw('supplier_total_remain -' . $pay)]);
    }

    public function allRequests($from, $to, $status)
    {

        if ($from && $to)
            $requetsts = MixinsItemRequest::where('branch_id', '=', auth()->user()->branch_id)->with(['type' => function ($q) {
                $q->select('type_id', 'type_name_ar')->where('is_deleted', false);
            }])->where('add_to_request', $status)->whereDate('added_request_date', '<=', $to)
                ->whereDate('added_request_date', '>=', $from)->get();

        return response()->json($requetsts);
    }
    public function findUnitByTypeIdAndUnitId($id, $typeId)
    {
        $unit = TypeUnits::where('branch_id', '=', auth()->user()->branch_id)->where('type_unit_id', $id)->where('type_id', $typeId)->first();
        return response()->json($unit);
    }
    function PaidDetails($type)
    {

        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $customersCash = CustomerPay::where('branch_id', '=', auth()->user()->branch_id)->with(['customer', 'user' => function ($q) {
            $q->select('id', 'name', 'branch_id');
        }, 'payMethods'])->where('is_pay', $type)->where('paid_date', '>=', $today)->get();
        return  json_encode($customersCash);
    }

    public function getOfferType($id)
    {
        $offers = Offer::where('branch_id', '=', auth()->user()->branch_id)->with(['mainOfferType', 'offerType'])->where('main_type', $id)->get()->all();

        return  json_encode($offers);
    }
    public function findBillById($id)
    {
        $bill = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with(['branch', 'worker' => function ($q) {
            $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
        }, 'billType', 'user' => function ($q) {
            $q->select('id', 'name', 'branch_id');
        },  'customer', 'payMethods', 'returns'])->where('id', '=', $id)->get()->all();
        return response()->json($bill);
    }
    public function  findBillWithTypeId($id)
    {
        $type = Type::with(['billType', 'branch', 'worker' => function ($q) {
            $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
        }, 'user' => function ($q) {
            $q->select('id', 'name', 'branch_id');
        },  'customer', 'payMethods', 'returns'])->where('is_deleted', false)->where('type_barcode', $id)->first();
        return response()->json($type);
    }




    public function processBillsReport($period, $from, $to)
    {
        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();
        $bills = null;
        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if (!auth()->user()->is_admin) {
            if ($period)
                if ($period == "daily") {
                    $bills = Returns::where('branch_id',  auth()->user()->branch_id)->with(['user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    },   'returnTypes'])
                        ->where('returns_date', '>=', $today)->get()->all();
                } else if ($period == "monthly") {
                    $bills = Returns::where('branch_id',  auth()->user()->branch_id)->with(['user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    },   'returnTypes'])
                        ->whereMonth('returns_date', date('m'))->get()->all();
                } else {
                    if ($from && $to)
                        $bills = Returns::with(['user' => function ($q) {
                            $q->select('id', 'name', 'branch_id');
                        },   'returnTypes'])
                            ->whereDate('returns_date', '<=', $to)
                            ->whereDate('returns_date', '>=', $from)->get()->all();
                }
        } else {
            if ($period)
                if ($period == "daily") {
                    $bills = Returns::with(['user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    },   'returnTypes'])
                        ->where('returns_date', '>=', $today)->get()->all();
                } else if ($period == "monthly") {
                    $bills = Returns::with(['user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    },   'returnTypes'])
                        ->whereMonth('returns_date', date('m'))->get()->all();
                } else {
                    if ($from && $to)
                        $bills = Returns::with(['user' => function ($q) {
                            $q->select('id', 'name', 'branch_id');
                        },   'returnTypes'])
                            ->whereDate('returns_date', '<=', $to)
                            ->whereDate('returns_date', '>=', $from)->get()->all();
                }
        }

        return response()->json($bills);
    }
    public function AllBranchesReport($period, $from, $to)
    {
        $mixins = Mixins::get()->all();
        $Calc = array();
        foreach ($mixins as $mixin) {
            $mytime = Carbon::now();
            $hour = $mytime->toArray()['hour'];
            if ($hour < $mixin->closure_hour) {
                $today = Carbon::yesterday()->setTime($mixin->closure_hour, 0);
            } else {
                $today = Carbon::today()->setTime($mixin->closure_hour, 0);
            }
            if ($period == "daily") {
                $Calc['total_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->where('returns_date', '>=', $today)->sum('total');
                $Calc['Vat_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->where('returns_date', '>=', $today)->sum('vat');
            } else if ($period == "monthly") {
                $Calc['total_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->whereMonth('returns_date', date('m'))->sum('total');
                $Calc['Vat_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->whereMonth('returns_date', date('m'))->sum('vat');
            } else {
                if ($from && $to)
                    $Calc['total_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('total');
                $Calc['Vat_' . $mixin->id] = Returns::where('branch_id',  $mixin->id)->whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('vat');
            }
        }
        return json_encode($Calc);
    }
    public function
    processBillsReportCalc($period, $from, $to)
    {

        $payMethods = PayMethods::get();
        $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
        $mytime = Carbon::now();
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $Calc
            = array();
        if (!auth()->user()->is_admin) {
            if ($period == "daily") {
                $Calc['total'] = Returns::where('branch_id',  auth()->user()->branch_id)->where('returns_date', '>=', $today)->sum('total');
                $Calc['Vat'] = Returns::where('branch_id',  auth()->user()->branch_id)->where('returns_date', '>=', $today)->sum('vat');
                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', Carbon::yesterday()->setTime($closure_hour->closure_hour,0))->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat'] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', Carbon::yesterday()->setTime($closure_hour->closure_hour,0))->sum('bill_vat_val');
                // }
            } else if ($period == "monthly") {
                $Calc['total'] = Returns::where('branch_id',  auth()->user()->branch_id)->whereMonth('returns_date', date('m'))->sum('total');
                $Calc['Vat'] = Returns::where('branch_id',  auth()->user()->branch_id)->whereMonth('returns_date', date('m'))->sum('vat');
                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereMonth('returns_date', date('m'))->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat']  = Returns::where('bill_paid_Type', $pay->id)->whereMonth('returns_date', date('m'))->sum('bill_vat_val');
                // }
            } else {
                if ($from && $to)
                    $Calc['total'] = Returns::where('branch_id',  auth()->user()->branch_id)->whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('total');
                $Calc['Vat'] = Returns::where('branch_id',  auth()->user()->branch_id)->whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('vat');

                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', $from)->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat']
                //         = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', $from)->sum('bill_vat_val');
                // }
            }
        } else {
            if ($period == "daily") {
                $Calc['total'] = Returns::where('returns_date', '>=', $today)->sum('total');
                $Calc['Vat'] = Returns::where('returns_date', '>=', $today)->sum('vat');
                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', Carbon::yesterday()->setTime($closure_hour->closure_hour,0))->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat'] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', Carbon::yesterday()->setTime($closure_hour->closure_hour,0))->sum('bill_vat_val');
                // }
            } else if ($period == "monthly") {
                $Calc['total'] = Returns::whereMonth('returns_date', date('m'))->sum('total');
                $Calc['Vat'] = Returns::whereMonth('returns_date', date('m'))->sum('vat');
                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereMonth('returns_date', date('m'))->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat']  = Returns::where('bill_paid_Type', $pay->id)->whereMonth('returns_date', date('m'))->sum('bill_vat_val');
                // }
            } else {
                if ($from && $to)
                    $Calc['total'] = Returns::whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('total');
                $Calc['Vat'] = Returns::whereBetween('returns_date', [$from, $to])->orWhereDate('returns_date', '>=', $from)->sum('vat');

                // foreach ($payMethods as $pay) {
                //     $Calc[$pay->pay_method_name_en] = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', $from)->sum('bill_total');
                //     $Calc[$pay->pay_method_name_en . 'Vat']
                //         = Returns::where('bill_paid_Type', $pay->id)->whereDate('returns_date', '>=', $from)->sum('bill_vat_val');
                // }
            }
        }
        return json_encode($Calc);
    }
    public function showIntable($id)
    {

        $bill = TableBill::with(['tableType' => function ($q) {
            $q->where('is_print', false);
        }, 'table', 'customer', 'user'])->where('id', $id)->first();
        return response()->json($bill);
    }
}
