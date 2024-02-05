<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Mixins;
use App\Models\PayMethods;
use Illuminate\Http\Request;
use App\Traits\ImagesTrait;
use DB;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ImagesTrait;

    public function index()
    {
        $expenses = Expense::where('branch_id', '=', auth()->user()->branch_id)->get()->all();
        return json_encode($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        if ($request->expense_icon) {
            $image_url = $this->UploadImage($request->expense_icon, 'backend/expense/');
        } else {
            $image_url = 'backend/expense/product.png';
        }
        $data['expense_title'] = $request->expense_title;
        $data['expense_cost'] = $request->expense_cost;
        $data['expense_date'] = $request->expense_date;
        $data['expense_vat'] = $request->vat;
        $data['paid_Type'] = $request->paid;
        $data['user_id'] = $request->user_id;
        $data['branch_id'] = auth()->user()->branch_id;

        $data['expense_icon'] = $image_url;
        DB::table('expenses')->insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::where('id', $id)->first();
        return response()->json($expense);
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
            $image_url = $this->UploadImage($request->newphoto, 'backend/expense/');
        } else {
            $image_url = 'backend/expense/product.png';
        }
        $data['expense_title'] = $request->expense_title;
        $data['expense_cost'] = $request->expense_cost;
        $data['expense_title'] = $request->expense_title;
        $data['expense_vat'] = $request->paid_Type;
        $data['user_id'] = $request->user_id;
        $data['expense_vat'] = $request->expense_vat;
        $data['paid_Type'] = $request->paid_Type;
        $data['user_id'] = $request->user_id;
        $data = DB::table('expenses')->where('id', $id)->update($data);
    }
    public function expensesReport($period, $from, $to)
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

        if (!auth()->user()->is_admin) {
            if ($period)
                if ($period == "daily") {
                    $expenses = Expense::where('branch_id',  auth()->user()->branch_id)->with(['user' => function ($q) {
                        $q->select('id', 'name');
                    }])
                        ->where('expense_date', '>=', $today)->get();
                } else if ($period == "monthly") {
                    $expenses = Expense::where('branch_id',  auth()->user()->branch_id)->with(['user' => function ($q) {
                        $q->select('id', 'name');
                    }])
                        ->whereMonth('expense_date', date('m'))->get();
                } else {
                    if ($from && $to)
                        $expenses = Expense::where('branch_id',  auth()->user()->branch_id)->with(['user' => function ($q) {
                            $q->select('id', 'name');
                        }])
                            ->whereDate('expense_date', '<=', $to)
                            ->whereDate('expense_date', '>=', $from)->get();
                }
        } else {
            if ($period)
                if ($period == "daily") {
                    $expenses = Expense::with(['user' => function ($q) {
                        $q->select('id', 'name');
                    }])
                        ->where('expense_date', '>=', $today)->get();
                } else if ($period == "monthly") {
                    $expenses = Expense::with(['user' => function ($q) {
                        $q->select('id', 'name');
                    }])
                        ->whereMonth('expense_date', date('m'))->get();
                } else {
                    if ($from && $to)
                        $expenses = Expense::with(['user' => function ($q) {
                            $q->select('id', 'name');
                        }])
                            ->whereDate('expense_date', '<=', $to)
                            ->whereDate('expense_date', '>=', $from)->get();
                }
        }
        return response()->json($expenses);
    }
    public function expensesReportCalc($period, $from, $to)
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

        if (!auth()->user()->is_admin) {
            if ($period == "daily") {
                $Calc['total'] = Expense::where('branch_id',  auth()->user()->branch_id)->where('expense_date', '>=', $today)->sum('expense_cost');
                $Calc['Vat'] = Expense::where('branch_id',  auth()->user()->branch_id)->where('expense_date', '>=', $today)->sum('expense_vat');
                $Calc['Count'] = Expense::where('branch_id',  auth()->user()->branch_id)->where('expense_date', '>=', $today)->count();
                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat'] = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count'] = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->count();
                }
            } else if ($period == "monthly") {

                $Calc['total'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereMonth('expense_date', date('m'))->sum('expense_cost');
                $Calc['Vat'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereMonth('expense_date', date('m'))->sum('expense_vat');
                $Calc['Count'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereMonth('expense_date', date('m'))->count();
                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat']  = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count']  = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->count();
                }
            } else {
                if ($from && $to)
                    $Calc['total'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_cost');
                $Calc['Vat'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_vat');
                $Calc['Count'] = Expense::where('branch_id',  auth()->user()->branch_id)->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->count();

                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat']
                        = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count']
                        = Expense::where('branch_id',  auth()->user()->branch_id)->where('paid_Type', $pay->id)->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->count();
                }
            }
        } else {
            if ($period == "daily") {
                $Calc['total'] = Expense::where('expense_date', '>=', $today)->sum('expense_cost');
                $Calc['Vat'] = Expense::where('expense_date', '>=', $today)->sum('expense_vat');
                $Calc['Count'] = Expense::where('expense_date', '>=', $today)->count();

                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat'] = Expense::where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count'] = Expense::where('paid_Type', $pay->id)->where('expense_date', '>=', $today)->count();
                }
            } else if ($period == "monthly") {
                $Calc['total'] = Expense::whereMonth('expense_date', date('m'))->sum('expense_cost');
                $Calc['Vat'] = Expense::whereMonth('expense_date', date('m'))->sum('expense_vat');
                $Calc['Count'] = Expense::whereMonth('expense_date', date('m'))->count();

                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat']  = Expense::where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count']  = Expense::where('paid_Type', $pay->id)->whereMonth('expense_date', date('m'))->count();
                }
            } else {
                if ($from && $to)
                    $Calc['total'] = Expense::whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_cost');
                $Calc['Vat'] = Expense::whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_vat');
                $Calc['Count'] = Expense::whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->count();

                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Expense::where('paid_Type', $pay->id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_cost');
                    $Calc[$pay->pay_method_name_en . 'Vat']
                        = Expense::where('paid_Type', $pay->id)->whereBetween('expense_date', [$from, $to])->orWhereDate('expense_date', '>=', $from)->sum('expense_vat');
                    $Calc[$pay->pay_method_name_en . 'Count']
                        = Expense::where('paid_Type', $pay->id)->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->count();
                }
            }
        }
        return json_encode($Calc);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('expenses')->where('id', $id)->delete();
    }
}
