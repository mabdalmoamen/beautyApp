<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillTypes;
use App\Models\Mixins;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        // if (!auth()->user()->is_admin) {

        // $workers = User::where('branch_id', '=', auth()->user()->branch_id)->where('is_user', 0)->get();
        // } else {
        $workers = User::where('is_user', 0)->get();
        // }
        return json_encode($workers);
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

        return response()->json(BillTypes::with('type')->where('worker_id', '=', $request->worker_id)
            ->where('created_at', '>=',  $today)
            ->orderBy($request->order, $request->orderType)->get());
    }
    public function isMonthlyBills($request)
    {

        return response()->json(BillTypes::with('type')->where('worker_id', '=', $request->worker_id)
            ->whereMonth('created_at', date('m'))
            ->orderBy($request->order, $request->orderType)->get());
    }
    public function isPeriodBills($request)
    {


        //return customer only
        return response()->json(BillTypes::with('type')->where('worker_id', '=', $request->worker_id)
            ->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->orderBy($request->order, $request->orderType)->get());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['is_user'] = 0;
        $data['mobile'] = $request->mobile;
        $data['hour_price'] = $request->hour_price;
        $data['work_hour_count'] = $request->work_hour_count;
        $data['jop_title'] = $request->jop_title;
        $data['salary'] = $request->salary;
        $data['commission'] = $request->commission;
        $data['is_percent_commission'] = $request->is_percent_commission;
        $data['branch_id'] = auth()->user()->branch_id;


        DB::table('users')->where('branch_id', '=', auth()->user()->branch_id)->insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = DB::table('users')->where('is_user', 0)->where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->first();
        if (!$user)
            $user = DB::table('users')->where('is_user', 0)->where('branch_id', '=', auth()->user()->branch_id)->where('name', $id)->first();
        if (!$user)
            $user = DB::table('users')->where('is_user', 0)->where('branch_id', '=', auth()->user()->branch_id)->where('mobile', $id)->first();
        return response()->json($user);
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
        DB::table('users')->where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->first();

        DB::table('users')->where('branch_id', '=', auth()->user()->branch_id)->where('id', $id)->delete();
    }
}
