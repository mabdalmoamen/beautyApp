<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Table;
use App\Models\TableBill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class TableOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return json_encode(TableBill::with(['tableType', 'payMethods', 'table', 'customer', 'user'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::connection()->disableQueryLog();
        if ($request->is_booking) {
            $tableBill = TableBill::where('id', $request->is_booking)->first();
            if ($tableBill) {
                DB::table('table_types')->where('table_bill_id', $request->is_booking)->delete();
                $tableBill->delete();
            }
        }
        $bill = array();
        $bill['bill_vat_val'] = $request->vat ?? 0.0;
        $bill['bill_discount'] = $request->discount ?? 0.0;
        $bill['offer_discount'] = $request->offerDiscount;
        $bill['bill_discount_percent'] = $request->billDiscountPercent;
        $bill['sum_after_discount'] = $request->sumAfterDiscount;
        $bill['bill_remain_val'] = $request->remain ?? 0.0;
        $bill['bill_paid_val'] = $request->paid ?? 0.0;
        $bill['bill_paid_type'] = $request->pay;
        $bill['bill_sum'] = $request->sum;
        $bill['bill_extra'] = $request->extra ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['bill_date'] = now();
        $bill['bill_notes'] = $request->note;
        $bill['user_id'] = auth()->user()->id;
        $bill['branch_id'] = auth()->user()->branch_id;
        $bill['cash'] = $request->cash ?? 0.0;
        $bill['card'] = $request->card ?? 0.0;
        $bill['cust_id'] = $request->customer['cust_id'] ?? null;
        $shift = Shift::where('branch_id', '=', auth()->user()->branch_id)->whereNull('end_date')->first();
        if ($shift) {
            switch ($request->pay) {
                case "1":
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->total)]);
                    break;
                case "2":
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('card +' . $request->total)]);
                    break;
                case "3":
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->paid)]);
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['later' => DB::raw('later +' . $request->remain)]);
                    break;
                case "4":
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->cash)]);
                    Shift::whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('later +' . $request->card)]);
                    break;
            }
        } else {
            $shift = array();
            $shift['current_user'] = auth()->user()->id;
            $shift['recived_user'] = null;
            $shift['starter_point'] = 0;
            $shift['cash'] = 0;
            $shift['card'] = 0;
            $shift['later'] = 0;
            switch ($request->pay) {
                case "1":
                    $shift['cash'] = (float) $this->getLastEndedCash() + $request->total;
                    break;
                case "2":
                    $shift['cash'] = (float) $this->getLastEndedCash();
                    $shift['card'] = $request->total ?? 0;
                    break;
                case "3":
                    $shift['cash'] = (float) $this->getLastEndedCash() + $request->paid;
                    $shift['later'] = $request->remain;
                    break;
                case "4":
                    $shift['cash'] = (float) $this->getLastEndedCash() + $request->cash;
                    $shift['card'] = $request->card ?? 0;
                    break;
                default:
                    break;
            }
            $shift['transfer'] = 0;
            $shift['increase'] = 0;
            $shift['deficit'] = 0;
            $shift['starter_date'] = now();
            $shift['end_date'] = null;
            $shift['branch_id'] =  auth()->user()->branch_id;
            Shift::create($shift);
        }
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

        $bill = TableBill::with(['tableType', 'payMethods', 'table', 'customer', 'user'])->where('id', $id)->first();
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
        $bill = TableBill::where('id', $id)->delete();
    }
    protected function insertBilltypes($contents, $bill_no)
    {
        $billdetails = array();
        foreach ($contents as $content) {
            if (isset($content['chair_id']) && $content['chair_id'] != null) {
                $tableBill = Table::where('id', $content['chair_id'])->first();
                if ($tableBill) {
                    $data = array();
                    $data['is_resrved'] = 1;
                    $data['end_reserve_date'] = Carbon::parse($content['end_reserve_date']);
                    $data['reserve_date'] =
                        Carbon::parse($content['reserve_date']);
                    DB::table('tables')->where('id', $content['chair_id'])->update($data);
                }
            }
            $billdetails['worker_id'] =  $content['worker_id'];
            $billdetails['commission'] = $content['commission'];
            $billdetails['chair_id'] = $content['chair_id'] ?? null;
            $billdetails['end_reserve_date'] = Carbon::parse($content['end_reserve_date']);
            $billdetails['reserve_date'] =
                Carbon::parse($content['reserve_date']);

            $billdetails['table_bill_id'] = $bill_no;
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['is_print'] = $content['is_print'] ?? false;
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['sell_unit'] = $content['sell_unit'] ? $content['sell_unit']['type_unit_id'] : null;
            $billdetails['type_price'] = $content['type_sill_price'];
            $billdetails['type_total_price'] = $content['total_type_cost'];
            $billdetails['type_note'] = $content['type_note'];
            $billdetails['type_vat'] = $content['type_vat_percent'];
            $billdetails['type_discount'] = $content['type_discount_value'];
            $billdetails['type_purchases_price'] = $content['type_purchases_price'];

            DB::table('table_types')->insert($billdetails);
        }
    }
    public function getLastEndedCash()
    {
        $shift = Shift::select('remain')->where('branch_id', '=', auth()->user()->branch_id)->whereNotNull('end_date')->orderBy('id', 'DESC')->first();

        if ($shift) {
            return  (float) $shift->remain;
        }
        return 0.0;
    }
}
