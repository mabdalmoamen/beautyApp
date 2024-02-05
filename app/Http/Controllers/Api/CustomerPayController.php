<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerPay;
use App\Models\Shift;
use Illuminate\Http\Request;
use DB;

class CustomerPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->is_admin) {
            $customersCash = CustomerPay::where('branch_id',  auth()->user()->branch_id)->where('branch_id', '=', auth()->user()->branch_id)->with('payMethods')->get();
        } else {
            $customersCash = CustomerPay::where('branch_id', '=', auth()->user()->branch_id)->with('payMethods')->get();
        }
        return  json_encode($customersCash);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pays = array();
        $pays['is_pay'] = $request->is_pay;
        $pays['paid_value'] = $request->pay;
        $pays['pay_method'] = $request->pay_method;
        $pays['user_id'] = $request->user_id;
        $pays['paid_date'] = now();
        $pays['branch_id'] = auth()->user()->branch_id;

        $pays['cust_id'] = $request->customer['cust_id'];
        $cust = DB::table('customers')->where('cust_id', $request->customer['cust_id'])->first();;
        $pays['cust_balance_before'] = $cust->cust_balance;
        $customer = DB::table('customers')
            ->where('cust_id', $request->customer['cust_id']);
        if ($pays['is_pay']) {
            $customer->update(['cust_balance' => DB::raw('cust_balance -' . $request->pay)]);
            $pays['note'] = "توريد نقدية";
            $shift = DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->first();
            if ($shift) {
                switch ($request->pay_method) {
                    case "1":
                        DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->pay)]);
                        break;
                    case "2":
                        DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('card +' . $request->pay)]);
                        break;
                    default:
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
                $shift['branch_id'] = auth()->user()->branch_id;


                switch ($request->pay_method) {
                    case "1":
                        $shift['cash'] = (float) $this->getLastEndedCash() + $request->pay;
                        break;
                    case "2":
                        $shift['cash'] = (float) $this->getLastEndedCash();
                        $shift['card'] = $request->pay ?? 0;
                        break;
                    default:
                        break;
                }

                $shift['transfer'] = 0;
                $shift['increase'] = 0;
                $shift['deficit'] = 0;
                $shift['starter_date'] = now();
                $shift['end_date'] = null;
                Shift::create($shift);
            }
        } else {
            $shift = DB::table('shifts')->where('branch_id', '=', auth()->user()->branch_id)->whereNull('end_date')->first();
            if ($shift) {
                switch ($request->pay_method) {
                    case "1":
                        if ($request->pay > $shift->cash) {
                            return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                        }
                        DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash -' . $request->pay)]);
                        break;
                    case "2":
                        if ($request->pay > $shift->cash) {
                            return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                        }
                        DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('card -' . $request->pay)]);
                        break;
                    default:
                        break;
                }

                $customer->update(['cust_balance' => DB::raw('cust_balance +' . $request->pay)]);
                $pays['note'] = "صرف نقدية";
            } else {
                return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
            }
        }
        $cust = DB::table('customers')->where('cust_id', $request->customer['cust_id'])->first();
        $pays['cust_after_after'] = $cust->cust_balance;

        $pays_no = DB::table('customer_pay')->insert($pays);
        return response($pays_no);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
   public function getLastEndedCash()
    {
        $shift = DB::table('shifts')->select('remain')->where('branch_id', '=', auth()->user()->branch_id)->whereNotNull('end_date')->orderBy('id', 'DESC')->first();

        if ($shift) {
            return  (float) $shift->remain;
        }
        return 0.0;
    }
}
