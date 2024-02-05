<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaveBillController extends Controller
{
    public function saveNewBill(Request $request, $data)
    {
        //
        return response($request->sum);

        //        return json_encode($data['product']);
    }
}
