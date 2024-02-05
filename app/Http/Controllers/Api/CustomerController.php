<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Expense;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use App\Models\CustomerPay;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where('branch_id', '=', auth()->user()->branch_id)->with('bills')->orderBy('cust_id', 'DESC')->paginate(10);
        return json_encode($customers);
    }

    public function customerReport($from, $to, $id)
    {
        if ($from && $to)
            $bills = Bill::where('branch_id', '=', auth()->user()->branch_id)->with('branch')->orderBy('bill_no', 'DESC')->with(['billType', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods', 'returns'])
                ->where('cust_id', $id)->whereDate('bill_date', '<=', $to)
                ->whereDate('bill_date', '>=', $from)->get();
        return response()->json($bills);
    }

    public function customerCashReport($from, $to, $id)
    {
        $customersCash = CustomerPay::where('branch_id', '=', auth()->user()->branch_id)->with(['user' => function ($q) {
            $q->select('id', 'name');
        }, 'customer' => function ($q) {
            $q->select('cust_id', 'cust_name');
        }, 'payMethods'])->whereDate('paid_date', '<=', $to)->whereDate('paid_date', '>=', $from)->where('cust_id', $id)->get();
        return  json_encode($customersCash);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        $customer = Customer::create($request->all());
        return  json_encode($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = DB::table('customers')->where('branch_id', '=', auth()->user()->branch_id)->where('cust_id', $id)->first();
        if (!$customer)
            $customer = DB::table('customers')->where('branch_id', '=', auth()->user()->branch_id)->where('cust_name', $id)->first();
        if (!$customer)
            $customer = DB::table('customers')->where('branch_id', '=', auth()->user()->branch_id)->where('cust_mobile', $id)->first();
        return response()->json($customer);
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
        DB::table('customers')->where('cust_id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('customers')->where('cust_id', $id)->first();

        DB::table('customers')->where('cust_id', $id)->delete();
    }
}
