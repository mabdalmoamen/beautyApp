<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Mixins;
use App\Models\PayMethods;
use App\Models\Point;
use App\Models\Shift;
use App\Models\Table;
use App\Models\TableBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Validator;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $bills = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with([
            'branch' => function ($q) {
                $q->select('id', 'mixins_name');
            },
            'billType', 'customer', 'sale',
            'worker' => function ($q) {
                $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
            }, 'user' => function ($q) {
                $q->select('id', 'name', 'branch_id');
            }, 'payMethods'
        ])->get();
        return json_encode($bills);
    }

    public function billsReport($period, $from, $to, $perPage)
    {
        DB::connection()->disableQueryLog();
        if ($period) {
            $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
        }
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if (!auth()->user()->is_admin) {
            if ($period == "daily") {
                $time =
                    $today;
                $bills = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with([
                    'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    }, 'billType', 'sale',
                    'worker' => function ($q) {
                        $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                    },
                    'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'customer', 'payMethods', 'returns'
                ])
                    ->where('bill_date', '>=', $today)->orderBy('bill_no', 'DESC')->paginate($perPage);
            } elseif ($period == "monthly") {
                $bills = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with([
                    'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    }, 'billType', 'sale',
                    'worker' => function ($q) {
                        $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                    },
                    'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'customer', 'payMethods', 'returns'
                ])
                    ->whereMonth('bill_date', date('m'))->orderBy('bill_no', 'DESC')->paginate($perPage);
            } else {
                if ($from && $to) {
                    $bills = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->with([
                        'branch' => function ($q) {
                            $q->select('id', 'mixins_name');
                        }, 'billType', 'sale',
                        'worker' => function ($q) {
                            $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                        },
                        'user' => function ($q) {
                            $q->select('id', 'name', 'branch_id');
                        }, 'customer', 'payMethods', 'returns'
                    ])
                        ->whereDate('bill_date', '>=', $from)
                        ->whereDate('bill_date', '<=', $to)->orderBy('bill_no', 'DESC')->paginate($perPage);
                }
            }
        } else {
            if ($period == "daily") {
                $time =
                    $today;
                $bills = Bill::where('is_deleted', false)->with([
                    'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    }, 'billType', 'sale',
                    'worker' => function ($q) {
                        $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                    },
                    'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'customer', 'payMethods', 'returns'
                ])
                    ->where('bill_date', '>=', $today)->orderBy('bill_no', 'DESC')->paginate($perPage);
            } elseif ($period == "monthly") {
                $bills = Bill::where('is_deleted', false)->with([
                    'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    }, 'billType', 'sale',

                    'worker' => function ($q) {
                        $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                    },
                    'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'customer', 'payMethods', 'returns'
                ])
                    ->whereMonth('bill_date', date('m'))->orderBy('bill_no', 'DESC')->paginate($perPage);
            } else {
                if ($from && $to) {
                    $bills = Bill::where('is_deleted', false)->with([
                        'branch' => function ($q) {
                            $q->select('id', 'mixins_name');
                        }, 'billType', 'sale',
                        'worker' => function ($q) {
                            $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
                        },
                        'user' => function ($q) {
                            $q->select('id', 'name', 'branch_id');
                        }, 'customer', 'payMethods', 'returns'
                    ])
                        ->whereDate('bill_date', '>=', $from)
                        ->whereDate('bill_date', '<=', $to)->orderBy('bill_no', 'DESC')->paginate($perPage);
                }
            }
        }
        return response()->json($bills);
    }
    public function billsReportCalc($period, $from, $to)
    {
        DB::connection()->disableQueryLog();
        $payMethods = PayMethods::get();
        $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
        $mytime = Carbon::now();
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $Calc
            = array();
        if (!auth()->user()->is_admin) {

            if ($period == "daily") {
                $Calc['total'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $today)->sum('bill_total');
                $Calc['Vat'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $today)->sum('bill_vat_val');
                $Calc['Count'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $today)->count();

                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_total');
                    $Calc[$pay->pay_method_name_en . 'Vat'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_vat_val');
                    $Calc[$pay->pay_method_name_en . 'Count'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->count();
                }
            } elseif ($period == "monthly") {
                $Calc['total'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->whereMonth('bill_date', date('m'))->sum('bill_total');
                $Calc['Vat'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                $Calc['Count'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->whereMonth('bill_date', date('m'))->count();
                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_total');
                    $Calc[$pay->pay_method_name_en . 'Vat']  = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                    $Calc[$pay->pay_method_name_en . 'Count']  = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->count();
                }
            } else {
                if ($from && $to) {
                    $Calc['total'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_total');
                    $Calc['Vat'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_vat_val');
                    $Calc['Count'] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->count();
                    foreach ($payMethods as $pay) {
                        $Calc[$pay->pay_method_name_en] = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_total');
                        $Calc[$pay->pay_method_name_en . 'Vat']
                            = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_vat_val');
                        $Calc[$pay->pay_method_name_en . 'Count']
                            = Bill::where('branch_id', '=', auth()->user()->branch_id)->where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->count();
                    }
                }
            }
        } else {
            if ($period == "daily") {
                $Calc['total'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $today)->sum('bill_total');
                $Calc['Vat'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $today)->sum('bill_vat_val');
                $Calc['Count'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $today)->count();
                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_total');
                    $Calc[$pay->pay_method_name_en . 'Vat'] = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->sum('bill_vat_val');
                    $Calc[$pay->pay_method_name_en . 'Count'] = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $today)->count();
                }
            } elseif ($period == "monthly") {
                $Calc['total'] = Bill::where('is_deleted', false)->whereMonth('bill_date', date('m'))->sum('bill_total');
                $Calc['Vat'] = Bill::where('is_deleted', false)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                $Calc['Count'] = Bill::where('is_deleted', false)->whereMonth('bill_date', date('m'))->count();
                foreach ($payMethods as $pay) {
                    $Calc[$pay->pay_method_name_en] = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_total');
                    $Calc[$pay->pay_method_name_en . 'Vat']  = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->sum('bill_vat_val');
                    $Calc[$pay->pay_method_name_en . 'Count']  = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->whereMonth('bill_date', date('m'))->count();
                }
            } else {
                if ($from && $to) {
                    $Calc['total'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_total');
                    $Calc['Vat'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_vat_val');
                    $Calc['Count'] = Bill::where('is_deleted', false)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->count();
                    foreach ($payMethods as $pay) {
                        $Calc[$pay->pay_method_name_en] = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_total');
                        $Calc[$pay->pay_method_name_en . 'Vat']
                            = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->sum('bill_vat_val');
                        $Calc[$pay->pay_method_name_en . 'Count']
                            = Bill::where('is_deleted', false)->where('bill_paid_Type', $pay->id)->where('bill_date', '>=', $from)->where('bill_date', '<=', $to)->count();
                    }
                }
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
        $id = Bill::select('id')->where('branch_id', auth()->user()->branch_id)->orderBy('bill_date', 'desc')->first();;
        DB::connection()->disableQueryLog();
        if ($request->is_booking) {
            $tableBill = TableBill::where('id', $request->is_booking)->first();
            if ($tableBill) {
                DB::table('table_types')->where('table_bill_id', $request->is_booking)->delete();
                $tableBill->delete();
                // $table = Table::find($request->table['id']);
            }
        }
        $bill = array();
        $bill['bill_sum'] = $request->sum;
        $bill['worker_id'] = $request->worker_id;
        $bill['commission'] = $request->commission;

        $bill['id'] = $id ? (int)$id->id + 1 : 1;
        $bill['sale_type'] = $request->sale ? $request->sale['id'] : null;
        $bill['table_id'] = $request->table['id'] ?? null;
        $bill['bill_vat_val'] = $request->vat ?? 0.0;
        $bill['bill_discount'] = $request->discount ?? 0.0;
        $bill['bill_extra'] = $request->extra ?? 0.0;
        $bill['bill_total'] = $request->total;
        $bill['offer_discount'] = $request->offerDiscount;
        $bill['bill_discount_percent'] = $request->billDiscountPercent;
        $bill['sum_after_discount'] = $request->sumAfterDiscount;
        $bill['is_included'] = $request->is_included;
        $bill['vat'] = $request->current_vat;
        $bill['branch_id'] = auth()->user()->branch_id;
        $bill['bill_remain_val'] = $request->remain ?? 0.0;
        $bill['bill_paid_val'] = $request->paid ?? 0.0;
        $bill['cash'] = $request->cash ?? 0.0;
        $bill['card'] = $request->card ?? 0.0;
        $bill['bill_notes'] = $request->note;
        $bill['sale_discount'] = $request->sale_discount;
        $bill['user_id'] = auth()->user()->id;
        $bill['bill_paid_type'] = $request->pay;
        $bill['pay_from_points'] = $request->pay_from_points;

        $bill['bill_date'] = now();
        $bill['cust_id'] = $request->customer['cust_id'] ?? null;
        $bill_no = DB::table('bills')->insertGetId($bill);
        $shift = DB::table('shifts')->where('branch_id', '=', auth()->user()->branch_id)->whereNull('end_date')->first();

        if ($shift) {
            switch ($request->pay) {
                case "1":
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->total)]);
                    break;
                case "2":
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('card +' . $request->total)]);
                    break;
                case "3":
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->paid)]);
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['later' => DB::raw('later +' . $request->remain)]);
                    break;
                case "4":
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['cash' => DB::raw('cash +' . $request->cash)]);
                    DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->update(['card' => DB::raw('later +' . $request->card)]);
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
        if ($bill['cust_id'] != null) {
            if (auth()->user()->branch->active_point && $request->pay_from_points) {
                Customer::where('cust_id', $bill['cust_id'])->update(['points' =>   $request->points]);
            }
            if (auth()->user()->branch->active_point && !$request->pay_from_points) {
                $this->validatePoint(auth()->user()->id, $bill['cust_id'], $bill['bill_total'] / auth()->user()->branch->point_every, Carbon::now()->addDays(auth()->user()->branch->valid_days));
            }
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();;
            $pays = array();
            $pays['cust_balance_before'] = $cust->cust_balance;
            $pays['is_pay'] = 1;
            $pays['paid_value'] = $request->paid;
            $pays['pay_method'] = 1;
            $pays['user_id'] = auth()->user()->id;
            $pays['paid_date'] = now();
            $pays['cust_id'] = $request->customer['cust_id'];
            $customer = DB::table('customers')->where('cust_id', $bill['cust_id']);
            $customer->update(['cust_balance' => DB::raw('cust_balance +' . $request->remain)]);
            $cust = DB::table('customers')->where('cust_id', $bill['cust_id'])->first();
            $pays['cust_after_after'] = $cust->cust_balance;
            $pays['note'] = 'فاتورة رقم ' . $bill_no;
            DB::table('customer_pay')->insert($pays);
        }
        $this->insertBilltypes($request->cart, $bill_no, $bill['bill_date']);
        // Artisan::call('DB:BackUp');

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
        $bill = Bill::where('is_deleted', false)->with([
            'branch' => function ($q) {
                $q->select('id', 'mixins_name');
            }, 'billType', 'table', 'sale', 'customer',
            'worker' => function ($q) {
                $q->select('id', 'name', 'commission', 'is_percent_commission', 'branch_id');
            },
            'user' => function ($q) {
                $q->select('id', 'name', 'branch_id');
            }, 'payMethods', 'returns', 'lastReturn' => function ($q) {
                return $q->orderBy('returns_date', 'DESC');
            }
        ])->where('bill_no', $id)->first();
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
        $shift = DB::table('shifts')->whereNull('end_date')->where('branch_id', '=', auth()->user()->branch_id)->first();
        if ($shift) {
            switch ($request->pay) {
                case "1":
                    if ($request->total > $shift->cash) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['cash' => DB::raw('cash -' . $request->total)]);
                    break;
                case "2":
                    if ($request->total > $shift->card) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['card' => DB::raw('card -' . $request->total)]);
                    break;
                case "3":
                    if ($request->total > $shift->later) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['later' => DB::raw('later -' . $request->total)]);
                    break;
                default:
                    if ($request->total > $shift->cash) {
                        return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
                    }
                    DB::table('shifts')->where('id', $shift->id)->update(['cash' => DB::raw('cash -' . $request->total)]);
                    break;
            }
        } else {
            return response()->json(['error' => 'عفوا لايوجد نقدية في الدرج!'], 401);
        }

        $currentBill = Bill::where('is_deleted', false)->where('bill_no', $id)->first();
        if ($currentBill->cust_id != null && $currentBill->bill_paid_type == 3) {
            $customer = DB::table('customers')->where('cust_id', $currentBill->cust_id);
            $customer->update(['cust_balance' => DB::raw('cust_balance -' . $request->total)]);
        }
        if ($request->process_bills) {
            $bill['returned'] = 1;
            DB::table('bills')->where('branch_id', '=', auth()->user()->branch_id)->where('bill_no', $id)->update($bill);
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
            DB::table('bills')->where('branch_id', '=', auth()->user()->branch_id)->where('bill_no', $id)->update($bill);
            $prevTypes = $request->prevtype;
            $billPrevTypes = array();
            foreach ($prevTypes as $content) {
                $this->manageReturnStock($content['type_id'], $content['sell_unit'], $content['returned_qty']);
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
        }
        return response($currentBill);
    }

    private function updateProcessBill(Request $request, $id)
    {
        $currentBill = Bill::where('is_deleted', false)->where('bill_no', $id)->first();

        $returns = array();
        $returns['sum'] = $request->sum;
        $returns['vat'] = $request->vat ?? 0.0;
        $returns['total'] = $request->total;
        $returns['bill_no'] = $id;
        $returns['user_id'] = auth()->user()->id;
        $returns['branch_id'] = $currentBill->branch_id;
        $returns['returns_date'] = now();
        $return_no = DB::table('returns')->insertGetId($returns);
        $contents = $request->cart;
        $billdetails = array();
        foreach ($contents as $content) {
            $this->manageReturnStock($content['type_id'], $content['sell_unit'], $content['returned_qty']);
            if ($content['returned_qty'] > 0) {
                $billdetails['return_id'] = $return_no;
                $billdetails['type_id'] = $content['type_id'];
                $billdetails['returned_qty'] = $content['returned_qty'];
                $billdetails['type_price'] = $content['type_price'];
                $billdetails['returned_total'] = $content['returned_total'];
                DB::table('bill_types')->where('bill_type_id', $content['bill_type_id'])->update(['total_return_qty' => DB::raw('total_return_qty +' . $content['returned_qty'])]);
                $billdetails['type_total_price'] = $content['type_price'] * $content['returned_qty'];
                $billdetails['type_count'] = $content['returned_qty'];
                DB::table('return_types')->insert($billdetails);
            }
        }



        return response($currentBill);
    }
    protected function manageReturnStock($tye_id, $sillunit, $typeCount)
    {
        $unit = DB::table('type_units')
            ->where('type_unit_id', $sillunit)->first();
        if ($unit) {
            $stocks = DB::table('gusto_type_stock')
                ->where('type_id', $tye_id)->where('unit_id', $unit->unit_id)->get();

            if ($stocks) {
                foreach ($stocks as $stock) {
                    DB::table('gusto_stocks')->where('id', $stock->stock_id)
                        ->update(['stock' => DB::raw('stock +' . $stock->mount * $typeCount)]);
                }
            }
        }
    }
    protected function manageStock($tye_id, $sillunit, $typeCount)
    {

        $unit = DB::table('type_units')
            ->where('type_unit_id', $sillunit)->first();
        if ($unit) {
            $stocks = DB::table('gusto_type_stock')
                ->where('type_id', $tye_id)->where('unit_id', $unit->unit_id)->get();
            if ($stocks) {
                foreach ($stocks as $stock) {
                    DB::table('gusto_stocks')->where('id', $stock->stock_id)
                        ->update(['stock' => DB::raw('stock -' . $stock->mount * $typeCount)]);
                }
            }
        }
    }
    protected function insertBilltypes($contents, $bill_no, $bill_date)
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

            $billdetails['bill_no'] = $bill_no;
            $billdetails['type_id'] = $content['type_id'];
            $billdetails['type_count'] = $content['type_count'];
            $billdetails['sell_unit'] = $content['sell_unit'] ? $content['sell_unit']['type_unit_id'] : null;
            $billdetails['type_price'] = $content['type_sill_price'];
            $billdetails['type_total_price'] = $content['total_type_cost'];
            $billdetails['type_vat'] = $content['type_vat_percent'];
            $billdetails['type_discount'] = $content['type_discount_value'];
            $billdetails['type_purchases_price'] = $content['type_purchases_price'];
            $billdetails['is_print'] = $content['is_print'];
            $billdetails['type_note'] = $content['type_note'];
            $billdetails['main_type'] = $content['main_type'];
            $billdetails['created_at'] = $bill_date;
            $billdetails['branch_id'] = auth()->user()->branch_id;
            DB::table('bill_types')->insert($billdetails);
            $this->manageStock($content['type_id'], $content['sell_unit'] ? $content['sell_unit']['type_unit_id'] : null, $content['type_count']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function validatePoint($user, $customer, $point_count, $valid_to)
    {
        $points = Point::where(['is_valid' => true, "cust_id" => $customer])->get();
        foreach ($points as $point) {

            if (Carbon::parse($point->valid_to)->isPast()) {
                $point->update(['is_valid' => false]);
                Customer::where('cust_id', $customer)->update(['points' => DB::raw('points -' . $point->point_count)]);
            }
        }
        Point::create([
            'user_id' => $user,
            'cust_id' => $customer,
            'point_count' => (int) $point_count,
            'valid_to' => $valid_to
        ]);
        Customer::where('cust_id', $customer)->update(['points' => DB::raw('points +' . $point_count)]);
    }
    public function destroy($id)
    {
        $data = array();
        $data['is_deleted'] = true;
        $data['delete_date'] = now();
        DB::table('bills')->where('branch_id', '=', auth()->user()->branch_id)->where('bill_no', $id)->update($data);
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