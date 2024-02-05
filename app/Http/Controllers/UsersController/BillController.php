<?php

namespace App\Http\Controllers\UsersController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {

        $bills = Bill::with('billType', 'customer', 'user', 'payMethods')->get();
        return view('users.index')->with(['bills' => $bills]);
    }
}
