<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Type;

class TrashController extends Controller
{
    //
    public function index()
    {
        return View('trash.index');
    }
    public function bills()
    {
        return json_encode(Bill::where('is_deleted', true)->get());
    }
    public function types()
    {
        return json_encode(Type::where('is_deleted', true)->get());
    }
    public function restore($id)
    {
        Type::where('type_id', $id)->update(['is_deleted' => false]);
    }
    public function restoreBill($id)
    {
        Bill::where('bill_no', $id)->update(['is_deleted' => false, 'delete_date' => null]);
    }
    public function delete($id)
    {
        Bill::where('bill_no', $id)->delete();
    }
}
