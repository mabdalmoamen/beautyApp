<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Mixins;
use App\Utils\helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function Report_Sales(Request $request)
    {
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        // Filter fields With Params to retrieve
        $param = array(0 => 'like', 1 => 'like', 2 => '=', 3 => 'like');
        $columns = array(0 => 'Ref', 1 => 'statut', 2 => 'cust_id', 3 => 'payment_statut');
        $data = array();

        $Sales = Bill::with('customer')
            ->where('bill_date', '>=', $request->from)
            ->where('bill_date', '<=', $request->to);

        //  Check If User Has Permission Show All Records
        $Sales = $helpers->Show_Records($Sales);
        //Multiple Filter
        $Filtred = $helpers->filter($Sales, $columns, $param, $request)
            // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->Where('customers.cust_name', 'LIKE', "%{$request->search}%");
                });
            });

        $totalRows = $Filtred->count();
        if ($perPage == "-1") {
            $perPage = $totalRows;
        }
        $Sales = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy('bills.' . $order, $dir)
            ->get();

        foreach ($Sales as $Sale) {

            $item['id'] = $Sale['bill_no'];
            $item['date'] = $Sale['bill_date'];
            $item['discount'] = $Sale['discount'];

            $data[] = $item;
        }

        $customers = Customer::get(['cust_id', 'cust_name']);
        return response()->json(['totalRows' => $totalRows, 'sales' => $data, 'customers' => $customers]);
    }
    public function report(Request $request)
    {
        $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();
        $mytime = Carbon::now();
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }

        if ($request->branch_id != "null") {

            if ($request->worker_id != "null" && $request->worker_id) {
                $id = $request->worker_id;
                return response()->json(Bill::where('is_deleted', false)
                    ->where('bill_date', '>=', $request->from)
                    ->where('bill_date', '<=', $request->to)
                    ->with(['billType' => function ($q) use ($id) {
                        $q->where('worker_id', '=', $id);
                    }, 'customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            if ($request->period == 0) {
                return $this->isDailyBillsWithBranch($request, $today);
            }
            if ($request->period == 1) {
                return $this->isMonthlyBillsWithBranch($request);
            }
            if ($request->period == 2) {
                return $this->isPeriodBillsWithBranch($request);
            }
        }
        if ($request->worker_id != "null" && $request->worker_id) {
            $id = $request->worker_id;

            return response()->json(Bill::where('is_deleted', false)
                ->where('bill_date', '>=', $request->from)
                ->where('bill_date', '<=', $request->to)
                ->with(['billType' => function ($q) use ($id) {
                    $q->where('worker.id', '=', $id);
                }, 'customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
        if ($request->period == 0) {

            return $this->isDailyBills($request, $today);
        }
        if ($request->period == 1) {
            return $this->isMonthlyBills($request);
        }
        if ($request->period == 2) {
            return $this->isPeriodBills($request);
        }
    }
    public function isDailyBills($request, $today)
    {
        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->where('bill_date', '>=',  $today)
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->where('bill_date', '>=',  $today)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return customer only
            return response()->json(Bill::where('is_deleted', false)
                ->where('bill_date', '>=',  $today)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
    public function isMonthlyBills($request)
    {
        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->whereMonth('bill_date', date('m'))
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return customer only
            return response()->json(Bill::where('is_deleted', false)
                ->whereMonth('bill_date', date('m'))
                ->where('bill_paid_type', '=', $request->pay)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->whereMonth('bill_date', date('m'))
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return if not customer
            return response()->json(Bill::where('is_deleted', false)
                ->whereMonth('bill_date', date('m'))
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
    public function isPeriodBills($request)
    {

        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->where('bill_date', '>=', $request->from)
                    ->where('bill_date', '<=', $request->to)
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return customer only
            return response()->json(Bill::where('is_deleted', false)
                ->where('bill_date', '>=', $request->from)
                ->where('bill_date', '<=', $request->to)
                ->where('bill_paid_type', '=', $request->pay)

                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)
                    ->where('bill_date', '>=', $request->from)
                    ->where('bill_date', '<=', $request->to)
                    ->where('bill_paid_type', '=', $request->pay)

                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }

            //return if not customer
            return response()->json(Bill::where('is_deleted', false)
                ->where('bill_date', '>=', $request->from)
                ->where('bill_date', '<=', $request->to)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
    public function isDailyBillsWithBranch($request, $today)
    {
        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->where('bill_date', '>=',  $today)
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->where('bill_date', '>=',  $today)
                ->where('cust_id', '=', $request->cust_id)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->where('bill_date', '>=',  $today)
                    ->where('bill_paid_type', '=', $request->pay)
                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }

            //return customer only
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->where('bill_date', '>=',  $today)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
    public function isMonthlyBillsWithBranch($request)
    {
        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->whereMonth('bill_date', date('m'))
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)

                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return customer only
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->whereMonth('bill_date', date('m'))

                ->where('bill_paid_type', '=', $request->pay)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->whereMonth('bill_date', date('m'))
                    ->where('bill_paid_type', '=', $request->pay)

                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return if not customer
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->whereMonth('bill_date', date('m'))
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
    public function isPeriodBillsWithBranch($request)
    {
        if ($request->cust_id != "null") {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->where('bill_date', '>=', $request->from)
                    ->where('bill_date', '<=', $request->to)
                    ->where('cust_id', '=', $request->cust_id)
                    ->where('bill_paid_type', '=', $request->pay)

                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }
            //return customer only
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->where('bill_date', '>=', $request->from)
                ->where('bill_date', '<=', $request->to)
                ->where('bill_paid_type', '=', $request->pay)

                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        } else {
            if ($request->pay != "null") {
                //return pay with customer
                return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                    ->where('bill_date', '>=', $request->from)
                    ->where('bill_date', '<=', $request->to)
                    ->where('bill_paid_type', '=', $request->pay)

                    ->with(['customer', 'user' => function ($q) {
                        $q->select('id', 'name', 'branch_id');
                    }, 'payMethods', 'branch' => function ($q) {
                        $q->select('id', 'mixins_name');
                    },])->orderBy($request->order, $request->orderType)->get());
            }

            //return if not customer
            return response()->json(Bill::where('is_deleted', false)->where('branch_id', '=', $request->branch_id)
                ->where('bill_date', '>=', $request->from)
                ->where('bill_date', '<=', $request->to)
                ->with(['customer', 'user' => function ($q) {
                    $q->select('id', 'name', 'branch_id');
                }, 'payMethods', 'branch' => function ($q) {
                    $q->select('id', 'mixins_name');
                },])->orderBy($request->order, $request->orderType)->get());
        }
    }
}
