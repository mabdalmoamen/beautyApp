<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MixinsRoles;
use App\Models\MixinsSuppliers;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use DB;

class MixinsRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mixinsRoles = MixinsRoles::get()->all();
        return  json_encode($mixinsRoles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userRoles = $request->userRoles;
        $contents = array();
        $user_id = $request->id;
        foreach ($userRoles as $content) {
            $contents['user_id'] = $user_id;
            $contents['mixins_role'] = $content['role_id'];
            DB::table('user_roles')->insert($contents);
        }
        return response($user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mixinsRole = DB::table('mixins_roles')->where('role_id', $id)->first();

        return response()->json($mixinsRole);
    }


    public function findRoleByUserId($id)
    {
        $mixinsRoles = UserRoles::with(['role' => function ($q) {
            $q->select('role_id', 'role_name', 'is_admin_role');
        }])->where('user_id', $id)->get();
        return response()->json($mixinsRoles);
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
        DB::table('mixins_roles')->where('role_id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('mixins_roles')->where('role_id', $id)->first();

        DB::table('mixins_roles')->where('role_id', $id)->delete();
    }
}
