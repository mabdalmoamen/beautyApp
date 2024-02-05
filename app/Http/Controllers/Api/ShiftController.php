<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mixins;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->is_admin) {
            $shift = Shift::with(['recivedUser', 'currentUser'])->whereNull('end_date')->first();
        } else {
            $shift = Shift::with(['recivedUser', 'currentUser'])->whereNull('end_date')->first();
        }
        return  json_encode($shift);
    }

    public function shiftReport($from, $to)
    {

        if ($from != "null" && $to != "null") {
            $shift = Shift::with(['recivedUser', 'currentUser'])
                ->whereDate('end_date', '>=', $from)->whereDate('end_date', '<=', $to)

                ->get()->all();
            return response()->json($shift);
        } else {
            $closure_hour = Mixins::select('closure_hour')->where('id', 1)->first();

            $shift = Shift::with(['recivedUser', 'currentUser'])->whereDate('end_date', '>=', Carbon::yesterday()->setTime($closure_hour->closure_hour, 0))->get()->all();
            return response()->json($shift);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $data = array();
        $data['branch_id'] = auth()->user()->branch_id;
        $codies = Mixins::where('id', auth()->user()->branch_id)->first();
        if ($codies->shift_field_required) {
            $validateData = $request->validate([
                'password' => 'required',
                'name' => 'required',
                'transfer' => 'required',

            ]);
            $credentials = request(['name', 'password']);
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'تأكد من بيانات الموظف المستلم !'], 401);
            }

            $user = DB::table('users')->where('name', $request->name)->first();
            $data['recived_user'] = $user->id;
        } else {

            $data['recived_user'] = auth()->user()->id;
        }

        $data['increase'] = $request->drawerCash > $request->cash ? $request->drawerCash - $request->cash : 0;
        $data['deficit'] = $request->drawerCash < $request->cash ? $request->cash - $request->drawerCash   : 0;
        $data['transfer'] = $request->transfer;
        $data['cash_entered'] = $request->drawerCash;
        $data['end_date'] = now();
        $data['remain'] = $request->remain;
        $shift = Shift::where('id', $id)->update($data);
        return response()->json(Shift::where('id', $id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
