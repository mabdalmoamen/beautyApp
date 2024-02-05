<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Mixins;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class UserAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();

        $hour = $mytime->toArray()['hour'];

        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $att = Attendance::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', true)->where('created_at', '>=', $today)->get();
        return json_encode(['users' => User::where('branch_id', '=', auth()->user()->branch_id)->all(), 'attendances' => $att, 'leaves' => Leave::with('user')->Where('status', false)->where('created_at', '>=', $today)->get()]);
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
    public function report($period, $from, $to, $uid)
    {
        $closure_hour = Mixins::select('closure_hour')->where('id', auth()->user()->branch_id)->first();
        $mytime = Carbon::now();
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }

        if ($period == "daily") {
            if ($uid != "undefined") {
                $users = User::where('branch_id', '=', auth()->user()->branch_id)->where("id", $uid)->orderBy('id', 'DESC')->with([
                    'attendances' => function ($q) use ($today) {
                        $q->where('created_at', '>=', $today)->get()->all();
                    },
                ])->get();
            } else {
                $users = User::where('branch_id', '=', auth()->user()->branch_id)->orderBy('id', 'DESC')->with([
                    'attendances' => function ($q) use ($today) {
                        $q->where('created_at', '>=', $today)->get()->all();
                    },
                ])->get();
            }
        } else if ($period == "monthly") {
            if ($uid != "undefined") {
                $users = User::where('branch_id', '=', auth()->user()->branch_id)->where("id", $uid)->orderBy('id', 'DESC')->with([
                    'attendances' => function ($q) {
                        $q->whereMonth('created_at', date('m'));
                    },
                ])->get();
            } else {
                $users = User::where('branch_id', '=', auth()->user()->branch_id)->orderBy('id', 'DESC')->with([
                    'attendances' => function ($q) {
                        $q->whereMonth('created_at', date('m'));
                    },
                ])->get();
            }
        } else {
            if ($to && $from) {
                if ($uid != "undefined") {
                    $users = User::where('branch_id', '=', auth()->user()->branch_id)->where("id", $uid)->orderBy('id', 'DESC')->with([
                        'attendances' => function ($q) use ($from, $to) {
                            $q->whereDate('created_at', '>=',  $from)
                                ->whereDate('created_at', '<=', $to)->get()->all();
                        },
                    ])->get();
                } else {
                    $users = User::where('branch_id', '=', auth()->user()->branch_id)->orderBy('id', 'DESC')->with([
                        'attendances' => function ($q) use ($from, $to) {
                            $q->whereDate('created_at', '>=',  $from)
                                ->whereDate('created_at', '<=', $to)->get()->all();
                        },
                    ])->get();
                }
            }
        }
        return json_encode(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $re)
    {
        if ($re) {
            if ($re->attend == true) {
                $AttendUser = User::where('branch_id', '=', auth()->user()->branch_id)->Where('pin_code', $re->code)->get()->first();
                if ($AttendUser) {
                    $isAttend = Attendance::where('branch_id', '=', auth()->user()->branch_id)->Where('uid', $AttendUser->id)->Where('status', true)->get()->first();
                    if (!$isAttend) {
                        $user = Leave::where('branch_id', '=', auth()->user()->branch_id)->Where('uid', $AttendUser->id)->Where('status', false)->get()->first();
                        if ($user) {
                            $updateUser = array();
                            $updateUser['status'] = true;
                            DB::table('leaves')->where('branch_id', '=', auth()->user()->branch_id)->where('uid', $AttendUser->id)->update($updateUser);
                        }

                        $attend = new Attendance();
                        $attend->uid = $AttendUser->id;

                        $attend->status = true;
                        $attend->branch_id = auth()->user()->branch_id;

                        $attend->save();
                        $msg = "تم تسجيل الدخول بنجاح";
                    } else {
                        $msg = "  تم  تسجيل الدخول  من قبل";
                    }
                } else {
                    $msg = "كود خاطيء";
                }
            } else {
                $leaveUser = User::where('branch_id', '=', auth()->user()->branch_id)->Where('pin_code', $re->code)->get()->first();
                if ($leaveUser) {
                    $isLeave = Leave::where('branch_id', '=', auth()->user()->branch_id)->Where('uid', $leaveUser->id)->Where('status', false)->get()->first();
                    if (!$isLeave) {
                        $user = Attendance::where('branch_id', '=', auth()->user()->branch_id)->Where('uid', $leaveUser->id)->Where('status', true)->get()->first();
                        if ($user) {
                            $updateUser = array();
                            $updateUser['status'] = false;
                            $updateUser['leave_date'] = Carbon::now();
                            $diff = Carbon::parse($user->created_at)->diffInMinutes(Carbon::parse(Carbon::now()));
                            $inhour = $diff / 60;
                            $updateUser['late_over'] = $inhour;

                            DB::table('attendances')->where('branch_id', '=', auth()->user()->branch_id)->where('uid', $leaveUser->id)->update($updateUser);
                        }

                        $leave = new Leave();
                        $leave->uid = $leaveUser->id;
                        $leave->status = false;
                        $leave->branch_id = auth()->user()->branch_id;

                        $leave->save();


                        $msg = "تم تسجيل الخروج";
                    } else {
                        $msg = "  يجب تسجيل الدخول أولا";
                    }
                } else {
                    $msg = "كود خاطيء";
                }
                return json_encode(['attendances' => Attendance::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', true)->get(), 'leaves' => Leave::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', false)->get(), 'message' => $msg]);
            }

            return json_encode(['attendances' => Attendance::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', true)->get(), 'leaves' => Leave::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', false)->get(), 'message' => $msg]);
        } else {
            return json_encode(['attendances' => Attendance::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', true)->get(), 'leaves' => Leave::where('branch_id', '=', auth()->user()->branch_id)->with('user')->Where('status', false)->get(), 'message' => "حدث خطأ ما"]);
        }
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
        //
    }
}
