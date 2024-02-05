<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PurchaseRequest;

use App\Http\Controllers\Controller;
use App\Models\Mixins;
use App\Models\MixinsPurchaseBills;
use App\Models\PayMethods;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Array_;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->is_admin) {

            $bills = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->with('billType', 'supplier', 'user')->get();
        } else {
            $bills = MixinsPurchaseBills::with('billType', 'supplier', 'user')->get();
        }
        return json_encode($bills);
    }

    public function purchasesBillReport($period, $from, $to)
    {

        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today =
                Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if ($period)
            if ($period == "daily") {
                $bills = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->with(['billType', 'user', 'supplier', 'payMethods'])

                    ->where('bill_date', '>=', $today)->get();
            } else if ($period == "monthly") {
                $bills = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->with(['billType', 'user', 'supplier', 'payMethods'])

                    ->whereMonth('bill_date', date('m'))->get();
            } else {
                if ($from && $to)
                    $bills = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->with(['billType', 'user', 'supplier', 'payMethods'])
                        ->whereDate('bill_date', '<=', $to)
                        ->whereDate('bill_date', '>=', $from)->get();
            }
        return response()->json($bills);
    }
    public function billsReportCalc($period, $from, $to)
    {
        $payMethods = PayMethods::get();
        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today =
                Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $Calc
            = array();
        if ($period == "daily") {
            $Calc['total'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_date', '>=', $today)->sum('bill_total');
            $Calc['Vat'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_date', '>=', $today)->sum('bill_vat_val');
            $Calc['Count'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_date', '>=', $today)->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->count();
            }
        } else if ($period == "monthly") {
            $Calc['total'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereMonth('bill_date', date('m'))->sum('bill_total');
            $Calc['Vat'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
            $Calc['Count'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereMonth('bill_date', date('m'))->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat']  = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count']  = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->count();
            }
        } else {
            if ($from && $to)
                $Calc['total'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereBetween('bill_date', [$from, $to])->orWhereDate('bill_date', '>=', $from)->sum('bill_total');
            $Calc['Vat'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereBetween('bill_date', [$from, $to])->orWhereDate('bill_date', '>=', $from)->sum('bill_vat_val');
            $Calc['Count'] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->whereDate('bill_date', '>=', $from)->whereDate('bill_date', '<=', $to)->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereBetween('bill_date', [$from, $to])->orWhereDate('bill_date', '>=', $from)->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat']
                    = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereBetween('bill_date', [$from, $to])->orWhereDate('bill_date', '>=', $from)->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count']
                    = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->where('bill_paid_Type', $pay->id)->whereDate('bill_date', '>=', $from)->whereDate('bill_date', '<=', $to)->count();
            }
        }
        return json_encode($Calc);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //        Main Bill Data
        $bill = array();
        $bill['bill_serial'] = $request->bill_serial;
        $bill['bill_sum'] = $request->sum;
        $bill['bill_vat_val'] = $request->vat ?? 0.0;
        $bill['bill_discount'] = $request->descount ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['bill_remain_val'] = $request->remain ?? 0.0;
        $bill['bill_paid_val'] = $request->paid ?? 0.0;
        $bill['bill_notes'] = $request->note;
        $bill['user_id'] = $request->user_id;
        $bill['bill_paid_type'] = $request->pay;
        $bill['bill_date'] = Carbon::now()->toDateTimeString();
        $bill['supplier_name'] = $request->supplier['supplier_id'];
        $bill['branch_id'] = auth()->user()->branch_id;



        $bill_no = DB::table('mixins_purchase_bills')->insertGetId($bill);

        //Insert Cart Data
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            $billdetails['purchase_bills'] = $bill_no;
            $billdetails['type_id'] = $content['id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['type_purchase_price'] = $content['type_price'];
            $billdetails['total_purchase_price'] = $content['total_purchase_price'];
            //           Update Type Stock
            DB::table('purchase_bill_types')->insert($billdetails);
            DB::table('gusto_stocks')
                ->where('id', $content['id'])->update(['type_price' => $content['type_price'], 'stock' => DB::raw('stock +' . $content['type_count'])]);
        }

        //        Calc Supplier Info
        DB::table('mixins_suppliers')
            ->where('supplier_id', $request->supplier['supplier_id'])
            ->update(['supplier_total_paid' => DB::raw('supplier_total_paid +' . $request->paid)]);
        DB::table('mixins_suppliers')
            ->where('supplier_id', $request->supplier['supplier_id'])
            ->update(['supplier_total_withdrawals' => DB::raw('supplier_total_withdrawals +' . $request->total)]);
        DB::table('mixins_suppliers')
            ->where('supplier_id', $request->supplier['supplier_id'])->update(['supplier_total_remain' => DB::raw('supplier_total_remain +' . $request->remain)]);
        //        End Calc Supplier
        return  json_encode($bill_no);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $bill = MixinsPurchaseBills::where('branch_id', '=', auth()->user()->branch_id)->with('billType')->where('purchase_bill_no', $id)->first();
        return response()->json($bill);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
