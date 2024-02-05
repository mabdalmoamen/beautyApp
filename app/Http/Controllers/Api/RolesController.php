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

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        //
        $users = User::where('is_user', 1)->get();
        return json_encode($users);
    }

    public function roles($id)
    {

        $user = User::with(["roles"])->where("id", $id)->first();
        return ["user" => $user];
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

        User::insert($data);
    }
    // $data=array();
    //         $data['period_report'] = $request->period_report;
    //         $data['bill_details'] = $request->bill_details;
    //         $data['is_admin'] = $request->is_admin;
    //         $data['is_user'] = $request->is_user;
    //         $data['status'] = $request->status;
    //         $data['bills'] = $request->bills;
    //         $data['new_bill'] = $request->new_bill;
    //         $data['puraches_bill'] = $request->puraches_bill;
    //         $data['expenses'] = $request->expenses;
    //         $data['puraches_bills'] = $request->puraches_bills;
    //         $data['delete_bill'] = $request->delete_bill;
    //         $data['delete_reserved_type'] = $request->delete_reserved_type;
    //         $data['resend'] = $request->resend;
    //         $data['change_type_in_kitchen'] = $request->change_type_in_kitchen;
    //         $data['customers'] = $request->customers;
    //         $data['delete_customer'] = $request->delete_customer;
    //         $data['edit_customer'] = $request->edit_customer;
    //         $data['create_customer'] = $request->create_customer;
    //         $data['users'] = $request->users;
    //         $data['delete_user'] = $request->delete_user;
    //         $data['edit_user'] = $request->edit_user;
    //         $data['create_user'] = $request->create_user;
    //         $data['user_roles'] = $request->user_roles;
    //         $data['change_price'] = $request->change_price;
    //         $data['types'] = $request->types;
    //         $data['create_type'] = $request->create_type;
    //         $data['delete_type'] = $request->delete_type;
    //         $data['edit_type'] = $request->edit_type;
    //         $data['reports'] = $request->reports;
    //         $data['daily_report'] = $request->daily_report;
    //         $data['monthly_report'] = $request->monthly_report;
    //         $data['bills_report'] = $request->bills_report;
    //         $data['puraches_bill_report'] = $request->puraches_bill_report;
    //         $data['expenses_reports'] = $request->expenses_reports;
    //         $data['process_bill'] = $request->process_bill;
    //         $data['process_bill_report'] = $request->process_bill_report;
    //         $data['stock'] = $request->stock;
    //         $data['pay_bill'] = $request->pay_bill;
    //         $data['remove_from_cart'] = $request->remove_from_cart;
    //         $data['bill_discount'] = $request->bill_discount;
    //         $data['type_discount'] = $request->type_discount;
    //         $data['bill_extra'] = $request->bill_extra;
    //         $data['shift'] = $request->shift;
    //         $data['shift_report'] = $request->shift_report;
    //         $data['customer_pay'] = $request->customer_pay;
    //         $data['customer_pay_report'] = $request->customer_pay_report;
    //         $data['suppliers'] = $request->suppliers;
    //         $data['supplier_report'] = $request->supplier_report;
    //         $data['create_supplier'] = $request->create_supplier;
    //         $data['edit_supplier'] = $request->edit_supplier;
    //         $data['delete_supplier'] = $request->delete_supplier;
    //         $data['settings'] = $request->settings;
    //         $data['units'] = $request->units;
    //         $data['create_unit'] = $request->create_unit;
    //         $data['edit_unit'] = $request->edit_unit;
    //         $data['offers'] = $request->offers;
    //         $data['create_offer'] = $request->create_offer;
    //         $data['edit_offer'] = $request->edit_offer;
    //         $data['delete_offer'] = $request->delete_offer;
    //         $data['barcode_settings'] = $request->barcode_settings;
    //         $data['print_barcode'] = $request->print_barcode;
    //         $data['reprint_bill'] = $request->reprint_bill;
    //         $data['main_types'] = $request->main_types;
    //         $data['create_main_type'] = $request->create_main_type;
    //         $data['edit_main_type'] = $request->edit_main_type;
    //         $data['delete_unit'] = $request->delete_unit;
    //         $data['delete_main_type'] = $request->delete_main_type;
    /**
     *
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user)
            $user = User::where('name', $id)->first();
        if (!$user)
            $user = User::where('mobile', $id)->first();
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

        User::where('id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

        User::where('id', $id)->delete();
    }
}
