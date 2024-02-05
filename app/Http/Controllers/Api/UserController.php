<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        // if (auth()->user()->is_user == 100 || auth()->user()->is_admin) {
        $users = User::where('is_user', 1)->get();
        return json_encode($users);
        // }
        // $users = User::where('branch_id', '=', auth()->user()->branch_id)->where('is_user', 1)->get();

        return json_encode($users);
    }

    public function roles($id)
    {

        $user = User::where('branch_id', '=', auth()->user()->branch_id)->with(["roles"])->where("id", $id)->first();
        return ["user" => $user];
    }
    public function checkHaveRole($role)
    {
        if (auth()->user()) {
            if ($role === 'undefined')
                return true;
            $user = DB::table('users')->where('id',  auth()->user()->id)->where($role, 1)->first();
            if (!$user) {
                return 0;
            }
            return true;
        }
        return 0;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(UersRequest $request)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['is_admin'] = $request->is_admin;
        $data['is_user'] = 1;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['mobile'] = $request->mobile;
        $data['hour_price'] = $request->hour_price;
        $data['work_hour_count'] = $request->work_hour_count;
        $data['jop_title'] = $request->jop_title;
        $data['salary'] = $request->salary;
        if ($request->branch_id) {
            $data['branch_id'] = $request->branch_id;
        } else {
            $data['branch_id'] = auth()->user()->branch_id;
        }

        DB::table('users')->insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::where('branch_id', '=', auth()->user()->branch_id)->with('branch')->where('id', $id)->first();
        if (!$user)
            $user = User::where('branch_id', '=', auth()->user()->branch_id)->with('branch')->where('name', $id)->first();
        if (!$user)
            $user = User::where('branch_id', '=', auth()->user()->branch_id)->with('branch')->where('mobile', $id)->first();
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

        $data = array();
        $data['name'] = $request->name;
        $data['is_admin'] = $request->is_admin;
        $data['is_user'] = 1;
        $data['email'] = $request->email;
        if ($request->newpassword) {
            $data['password'] = bcrypt($request->newpassword);
        }
        $data['mobile'] = $request->mobile;
        $data['hour_price'] = $request->hour_price;
        $data['work_hour_count'] = $request->work_hour_count;
        $data['jop_title'] = $request->jop_title;
        $data['salary'] = $request->salary;
        $data['branch_id'] = $request->branch_id;
        DB::table('users')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

        DB::table('users')->where('id', $id)->delete();
    }
}
