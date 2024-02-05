<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillTypes;
use App\Models\Bill;
use App\Models\Mixins;
use App\Models\PayMethods;
use App\Models\Returns;
use App\Models\Shift;
use App\Models\TableBill;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use function PHPUnit\Framework\isEmpty;

class CashierBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bill::with('billType', 'sale', 'customer', 'user', 'payMethods')->get();
        return json_encode($bills);
    }

    public function billsReport($period, $from, $to, $perPage)
    {
        if ($period)
            $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today = Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today =
                Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if ($period == "daily") {
            $bills = Bill::with(['billType', 'sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' , 'payMethods', 'returns'])
                ->where('bill_date', '>', $today)->orderBy('bill_no', 'DESC')->paginate($perPage);
        } else if ($period == "monthly") {
            $bills = Bill::with(['billType', 'sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' , 'payMethods', 'returns'])
                ->whereMonth('bill_date', date('m'))->orderBy('bill_no', 'DESC')->paginate($perPage);
        } else {
            if ($from && $to)
                $bills = Bill::with(['billType', 'sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' , 'payMethods', 'returns'])
                    ->whereDate('bill_date', '<=', $to)
                    ->whereDate('bill_date', '>=', $from)->orderBy('bill_no', 'DESC')->paginate($perPage);
        }
        return response()->json($bills);
    }
    public function billsReportCalc($period, $from, $to)
    {
        $payMethods = PayMethods::get();
        $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
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
            $Calc['total'] = Bill::where('bill_date', '>', $today)->sum('bill_total');
            $Calc['Vat'] = Bill::where('bill_date', '>', $today)->sum('bill_vat_val');
            $Calc['Count'] = Bill::where('bill_date', '>', $today)->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = Bill::where('bill_paid_Type', $pay->id)->where('bill_date', '>', $today)->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat'] = Bill::where('bill_paid_Type', $pay->id)->where('bill_date', '>', $today)->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count'] = Bill::where('bill_paid_Type', $pay->id)->where('bill_date', '>', $today)->count();
            }
        } else if ($period == "monthly") {
            $Calc['total'] = Bill::whereMonth('bill_date', date('m'))->sum('bill_total');
            $Calc['Vat'] = Bill::whereMonth('bill_date', date('m'))->sum('bill_vat_val');
            $Calc['Count'] = Bill::whereMonth('bill_date', date('m'))->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = Bill::where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat']  = Bill::where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count']  = Bill::where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->count();
            }
        } else {
            if ($from && $to)
                $Calc['total'] = Bill::whereDate('bill_date', '>=', $from)->sum('bill_total');
            $Calc['Vat'] = Bill::whereDate('bill_date', '>=', $from)->sum('bill_vat_val');
            $Calc['Count'] = Bill::whereDate('bill_date', '>=', $from)->count();

            foreach ($payMethods as $pay) {
                $Calc[$pay->pay_method_name_en] = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', '>=', $from)->sum('bill_total');
                $Calc[$pay->pay_method_name_en . 'Vat']
                    = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', '>=', $from)->sum('bill_vat_val');
                $Calc[$pay->pay_method_name_en . 'Count']
                    = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', '>=', $from)->count();
            }
        }
        return json_encode($Calc);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->pendingBill) {
            TableBill::where('id', $request->pendingBill['id'])->delete();
        }
        $shift = DB::table('shifts')->whereNull('end_date')->first();
        if ($shift) {
            switch ($request->pay) {
                case (1):
                    DB::table('shifts')->whereNull('end_date')->update(['cash' => DB::raw('cash +' . $request->total)]);
                    break;
                case (2):
                    DB::table('shifts')->whereNull('end_date')->update(['card' => DB::raw('card +' . $request->total)]);
                    break;
                default:
                    DB::table('shifts')->whereNull('end_date')->update(['cash' => DB::raw('cash +' . $request->paid)]);
                    DB::table('shifts')->whereNull('end_date')->update(['later' => DB::raw('later +' . $request->remain)]);
                    break;
            }
        } else {

            $shift = array();
            $shift['current_user'] = $request->user_id;
            $shift['recived_user'] = null;
            $shift['starter_point'] = 0;
            $shift['cash'] = 0;
            $shift['card'] = 0;
            $shift['later'] = 0;
            switch ($request->pay) {
                case 1:
                    $shift['cash'] = $this->getLastEndedCash() + $request->total;
                    break;
                case 2:
                    $shift['cash'] = $this->getLastEndedCash();
                    $shift['card'] = $request->card ?? 0;
                    break;
                default:
                    $shift['cash'] = $this->getLastEndedCash() + $request->paid;
                    $shift['later'] = $request->remain;
                    break;
            }
            $shift['transfer'] = 0;
            $shift['increase'] = 0;
            $shift['deficit'] = 0;
            $shift['starter_date'] = now();
            $shift['end_date'] = null;
            Shift::create($shift);
        }
        $bill = array();
        $bill['sale_type'] = $request->sale ? $request->sale['id'] : NUll;
        $bill['sale_discount'] = $request->sale_discount;
        $bill['bill_sum'] = $request->sum;
        $bill['bill_vat_val'] = $request->vat ?? 0.0;
        $bill['bill_discount'] = $request->discount ?? 0.0;
        $bill['bill_extra'] = $request->extra ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['is_included'] = $request->is_included;
        $bill['vat'] = $request->current_vat;
        $bill['offer_discount'] = $request->offerDiscount;
        $bill['bill_discount_percent'] = $request->billDiscountPercent;
        $bill['sum_after_discount'] = $request->sumAfterDiscount;

        $bill['bill_remain_val'] = $request->remain ?? 0.0;
        $bill['bill_paid_val'] = $request->paid ?? 0.0;
        $bill['bill_notes'] = $request->note;
        $bill['user_id'] = $request->user_id;
        $bill['bill_paid_type'] = $request->pay;
        $bill['bill_date'] = now();
        $bill['cust_id'] = $request->customer['cust_id'] ?? null;

        $bill_no = DB::table('bills')->insertGetId($bill);
        if ($bill['cust_id'] != null) {
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();;
            $pays = array();
            $pays['cust_balance_before'] = $cust->cust_balance;
            $pays['is_pay'] = 1;
            $pays['paid_value'] = $request->paid;
            $pays['pay_method'] = 1;
            $pays['user_id'] = $request->user_id;
            $pays['paid_date'] = now();
            $pays['cust_id'] = $request->customer['cust_id'];
            $customer = DB::table('customers')->where('cust_id', $bill['cust_id']);
            $customer->update(['cust_balance' => DB::raw('cust_balance +' . $request->remain)]);
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();
            $pays['cust_after_after'] = $cust->cust_balance;
            $pays['note'] = 'فاتورة رقم ' . $bill_no;
            DB::table('customer_pay')->insert($pays);
        }
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            $billdetails['bill_no'] = $bill_no;
            $billdetails['type_purchases_price'] = $content['type_purchases_price'];
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['type_discount'] = $content['type_discount_value'];
            $billdetails['type_discount_percent'] = $content['type_discount_percent'];
            $billdetails['sell_unit'] = $content['sell_unit'] != null ? $content['sell_unit']['type_unit_id'] : null;
            $billdetails['type_price'] = $content['type_sill_price'];
            $billdetails['type_total_price'] = $content['total_type_cost'];
            $billdetails['type_note'] = $content['type_note'];
            DB::table('bill_types')->insert($billdetails);
            $type = DB::table('mixins_type_stock')
                ->where('type_stock_id', $content['type_id'])->first();
            if ($type) {
                if ($content['calc_count'] != null && $content['calc_count'] > 0) {
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock -' . $content['calc_count'])]);
                } else {
                    DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock -' . $content['type_count'])]);
                }

                $type = DB::table('mixins_type_stock')
                    ->where('type_stock_id', $content['type_id'])->first();
                if ($type->mixins_type_stock <= 0) {
                    DB::table('mixins_type_stock')->where('mixins_type_stock_id', $type->mixins_type_stock_id)->delete();
                }
            } else {
                $typeStock = DB::table('types_sold_without_balance')->where('type_id', $content['type_id'])->first();
                if ($typeStock) {
                    DB::table('types_sold_without_balance')->where('type_id', $content['type_id'])->update(['qty' => DB::raw('qty +' . $content['type_count'])]);
                } else {
                    $typeStock = array();
                    $typeStock['type_id'] = $content['type_id'];
                    $typeStock['qty'] = $content['type_count'];
                    DB::table('types_sold_without_balance')->insert($typeStock);
                }
            }
        }
        Artisan::call('DB:BackUp');

        return response($bill_no);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $bill = Bill::with(['billType','sale', 'customer',  'user', 'payMethods', 'returns'])->where('bill_no', $id)->first();
        return response()->json($bill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        $shift = DB::table('shifts')->whereNull('end_date')->first();
        if ($shift) {
            switch ($request->pay) {
                case (1):
                    if ($request->total > $shift->cash) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['cash' => DB::raw('cash -' . $request->total)]);
                    break;
                case (2):
                    if ($request->total > $shift->card) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['card' => DB::raw('card -' . $request->total)]);
                    break;
                default:
                    if ($request->total > $shift->later) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['later' => DB::raw('later -' . $request->total)]);
                    break;
            }
        } else {
            return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
        }
        $currentBill = Bill::with(['billType', 'sale', 'customer', 'user', 'payMethods', 'returns'])->where('bill_no', $id)->first();
        if ($currentBill->cust_id != null && $currentBill->bill_paid_type === 3) {
            $cust = DB::table('customers')->where('cust_id', $currentBill->cust_id)->first();;
            $pays = array();
            $pays['cust_balance_before'] = $cust->cust_balance;
            $pays['is_pay'] = 1;
            $pays['paid_value'] = $request->paid;
            $pays['pay_method'] = 1;
            $pays['user_id'] = $request->user_id;
            $pays['paid_date'] = now();
            $pays['cust_id'] = $currentBill->cust_id;
            $customer = DB::table('customers')->where('cust_id', $currentBill->cust_id);
            $customer->update(['cust_balance' => DB::raw('cust_balance -' . $request->total)]);
        }
        if ($request->process_bills) {
            $bill = array();
            $bill['returned'] = 1;
            DB::table('bills')->where('bill_no', $id)->update($bill);
            $this->updateProcessBill($request, $id);
        } else {
            $bill = array();
            $bill['returned'] = 1;
            $bill['bill_sum'] = $currentBill->bill_sum - $request->sum;
            $bill['bill_vat_val'] = $currentBill->bill_vat_val - $request->vat ?? 0.0;
            $bill['bill_total'] = $currentBill->bill_total - $request->total;
            $bill['return_sum'] = $currentBill->return_sum + $request->sum ?? 0.0;
            $bill['return_vat'] = $currentBill->return_vat + $request->total;
            $bill['return_sum'] = $currentBill->return_sum + $request->sum ?? 0.0;
            $bill['return_vat'] = $currentBill->return_vat + $request->vat;
            $bill['total_returned'] = $currentBill->total_returned + $request->total;
            DB::table('bills')->where('bill_no', $id)->update($bill);
            $contents = $request->cart;
            foreach ($contents as $content) {
                if ($content['returned_qty'] > 0 && ($content['type_count'] - $content['returned_qty']) > 0) {
                    $type = DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->first();
                    if ($type) {
                        if ($content['calc_count'] != null && $content['calc_count'] > 0) {
                            DB::table('mixins_type_stock')
                                ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['calc_count'])]);
                        } else {
                            DB::table('mixins_type_stock')
                                ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['returned_qty'])]);
                        }
                        $type = DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->first();
                    } else {
                        //                insert Type If not Has Stock
                        $type = array();
                        $type['type_stock_id'] = $content['type_id'];
                        $type['mixins_type_stock'] = $content['type_count'];
                        DB::table('mixins_type_stock')->insert($type);
                    }
                } else {
                    $type = DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->first();
                    if ($type) {
                        if ($content['calc_count'] != null && $content['calc_count'] > 0) {
                            DB::table('mixins_type_stock')
                                ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['calc_count'])]);
                        } else {
                            DB::table('mixins_type_stock')
                                ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['returned_qty'])]);
                        }
                    }
                }
            }
            $prevTypes = $request->prevtype;
            $billPrevTypes = array();
            if ($content['returned_qty'] > 0) {
                $billPrevTypes['type_count'] = $content['type_count'] - $content['returned_qty'];
                $billPrevTypes['type_total_price'] = $content['type_price'] * $billPrevTypes['type_count'];
                if ($billPrevTypes['type_count'] != 0) {
                    DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update($billPrevTypes);
                    $billPrevTypes['bill_no'] = $currentBill->bill_no;
                    $billPrevTypes['returned'] = 1;
                    $billPrevTypes['type_id'] = $content['type_id'];
                    $billPrevTypes['sell_unit'] = $content['sell_unit'];
                    $billPrevTypes['type_count'] = $content['returned_qty'];
                    $billPrevTypes['returned_total'] = $content['type_price'] * $content['returned_qty'];
                    $billPrevTypes['type_total_price'] = $content['type_price'] * $content['returned_qty'];
                    DB::table('bill_types')->insert($billPrevTypes);
                } else {

                    $billPrevTypes['returned'] = 1;
                    $billPrevTypes['type_count'] = $content['returned_qty'];
                    $billPrevTypes['returned_qty'] = $content['returned_qty'];
                    $billPrevTypes['returned_total'] = $content['type_price'] * $billPrevTypes['returned_qty'];
                    $billPrevTypes['type_total_price'] = $content['type_price'] * $billPrevTypes['returned_qty'];
                    DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update($billPrevTypes);
                }
            }
        }
        return response($currentBill);
    }

    private function updateProcessBill(Request $request, $id)
    {
        $currentBill = Bill::with(['billType', 'sale', 'customer', 'user', 'payMethods', 'returns'])->where('bill_no', $id)->first();

        $returns = array();
        $returns['sum'] = $request->sum;
        $returns['vat'] = $request->vat ?? 0.0;
        $returns['total'] = $request->total;
        $returns['bill_no'] = $id;
        $returns['user_id'] = $request->user_id;
        $returns['returns_date'] = now();
        $return_no = DB::table('returns')->insertGetId($returns);
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            if ($content['returned_qty'] > 0) {
                $billdetails['return_id'] = $return_no;
                $billdetails['type_id'] = $content['type_id'];
                $billdetails['returned_qty'] = $content['returned_qty'];
                $billdetails['type_price'] = $content['type_price'];
                $billdetails['returned_total'] = $content['returned_total'];
                $billdetails['type_total_price'] = $content['type_price'] * $content['returned_qty'];
                $billdetails['type_count'] = $content['returned_qty'];
                DB::table('return_types')->insert($billdetails);

                $type = DB::table('mixins_type_stock')
                    ->where('type_stock_id', $content['type_id'])->first();
                if ($type) {
                    if ($content['calc_count'] != null && $content['calc_count'] > 0) {
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['calc_count'])]);
                    } else {
                        DB::table('mixins_type_stock')
                            ->where('type_stock_id', $content['type_id'])->update(['mixins_type_stock' => DB::raw('mixins_type_stock +' . $content['returned_qty'])]);
                    }
                    $type = DB::table('mixins_type_stock')
                        ->where('type_stock_id', $content['type_id'])->first();
                } else {
                    //                insert Type If not Has Stock
                    $type = array();
                    $type['type_stock_id'] = $content['type_id'];
                    $type['mixins_type_stock'] = $content['type_count'];
                    DB::table('mixins_type_stock')->insert($type);
                }
            }
        }
        $prevTypes = $request->prevtype;
        $billPrevTypes = array();
        foreach ($prevTypes as $content) {
            if ($content['returned_qty'] > 0) {
                $billPrevTypes['returned'] = 1;
                DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update($billPrevTypes);
            }
        }


        return response($currentBill);
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
    public function getLastEndedCash()
    {
        $shift = DB::table('shifts')->whereNotNull('end_date')->orderBy('id', 'DESC')->first();
        if (!isEmpty($shift)) {
            return  json_encode($shift->remain);
        }
    }
}
