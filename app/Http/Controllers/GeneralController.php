<?php

namespace App\Http\Controllers;

use App\DataTables\TypeDataTable;
use App\DataTables\TypesDataTable;
use App\Models\Bill;
use App\Models\BillTypes;
use App\Models\Mixins;
use App\Models\MixinsMainTypes;
use App\Models\User;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class GeneralController extends Controller
{
    public function index(TypesDataTable $dataTable)
    {
        if ($dataTable->query() != null) {
            return $dataTable->render('types', ['categories' => BillTypes::with('type')->all(), 'mixins' => Mixins::where('id', 1)->first(), 'sill_price' => $dataTable->query()->sum('type_total_price'), 'purchases_price' => $dataTable->query()->sum('type_purchases_price')]);
        } else {
            return   $dataTable->render('types', ['categories' => BillTypes::with('type')->all(), 'mixins' => Mixins::where('id', 1)->first(),]);
        }
    }
    public function types(TypeDataTable $dataTable)
    {
        return   $dataTable->render('index-types');
    }
    public function TypeReport(Request $request)
    {

        $bills = null;
        $closure_hour = Mixins::where('id', 1)->first();
        $mytime = Carbon::now();
        App::setLocale($closure_hour->default_lang);
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }

        if ($request->period == "daily") {
            if ($request->cat_id && $request->cat_id  != '') {
                $bills = $this->IsDailyCategory($today, $request);
            } else {
                $bills = $this->IsDaily($today, $request);
            }
        } else if ($request->period == "monthly") {
            if ($request->cat_id && $request->cat_id  != '') {
                $bills = $this->isMonthlyCategory($request);
            } else {
                $bills = $this->isMonthly($request);
            }
        } else {

            if ($request->cat_id  != '') {
                $bills = $this->isPeriodCategory($request);
            } else {
                $bills = $this->isPeriod($request);
            }
        }


        return response()->json($bills);

        // return  view('types')->with(['types' => $filtertypes, 'categories' => BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->all(), 'mixins' => Mixins::where('id', 1)->first(),]);

        // return $filtertypes;
    }
    public function isPeriod($request)
    {
        if ($request->type_id  != '') {
            if ($request->from != ''  && $request->to != '')
                $bills =
                    BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->where('created_at', '>=', $request->from)
                    ->where('created_at', '<=', $request->to)->get();
        } else {
            $bills = BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('created_at', '>=', $request->from)->where('created_at', '<=',  $request->to)
                ->get();
        }

        return $bills;
    }
    public function isMonthly($request)
    {
        if ($request->type_id && $request->type_id  != '') {

            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->whereMonth('created_at', date('m'))->get();
        } else {

            $bills
                =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->whereMonth('created_at', date('m'))->get();
        }
        return $bills;
    }
    public function IsDaily($today, $request)
    {

        if ($request->type_id && $request->type_id  != '') {

            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->where('created_at', '>=',  $today)->get();
        } else {

            $bills
                =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('created_at', '>=',  $today)->get();
        }

        return $bills;
    }

    public function isPeriodCategory($request)
    {
        if ($request->type_id && $request->type_id  != '') {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->where('main_type',  $request->cat_id)->where('created_at', '>=', $request->from)
                ->where('created_at', '<=', $request->to)->get();
        } else {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('main_type',  $request->cat_id)->where('created_at', '>=', $request->from)
                ->where('created_at', '<=', $request->to)->get();
        }
        return $bills;
    }
    public function isMonthlyCategory($request)
    {
        if ($request->type_id && $request->type_id  != '') {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->where('main_type',  $request->cat_id)->whereMonth('created_at', date('m'))->get();
        } else {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('main_type',  $request->cat_id)->whereMonth('created_at', date('m'))->get();
        }
        return $bills;
    }
    public function IsDailyCategory($today, $request)
    {
        if ($request->type_id && $request->type_id  != '') {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('type_id', $request->type_id)->where('main_type',  $request->cat_id)->where('created_at', '>=',  $today)->get();
        } else {
            $bills =
                BillTypes::with('type')->where('branch_id', '=', $request->branch_id)->where('main_type',  $request->cat_id)->where('created_at', '>=',  $today)->get();
        }
        return $bills;
    }
}
