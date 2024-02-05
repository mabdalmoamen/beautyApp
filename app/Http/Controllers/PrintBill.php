<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Mixins;
use App\Models\TableBill;
use Illuminate\Http\Request;
use DB;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class PrintBill extends Controller
{
    public function test()
    {
       $mixins= Mixins::where('id', 1)->first();
        // Set params
        $mid = '123123456';
        $store_name = 'Codies';
        $store_address = 'Codies Address';
        $store_phone = '01002208627';
        $store_email = 'Codies@Codies.com';
        $store_website = 'Codies.com';
        $tax_percentage = 15;
        $transaction_id = '01002208627';

        // Set items
        $items = [
            [
                'name' => 'test',
                'qty' => 2,
                'price' => 100,
            ],
            [
                'name' => 'Test 1',
                'qty' => 1,
                'price' => 200,
            ],
            [
                'name' => 'test 2',
                'qty' => 3,
                'price' => 300,
            ],
            [
                'name' => 'test 3',
                'qty' => 3,
                'price' => 400,
            ],
        ];

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            'network',
            '192.168.123.100'
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();
    }
    public function index($id)
    {
        DB::connection()->disableQueryLog();

        $bill = TableBill::with(['tableType' => function ($q) {
            $q->where('is_print', false);
        }, 'table', 'customer', 'user'])->where('id', $id)->first();
        // dd($bill);

        return view('test')->with(['bills' => $bill, 'mixins' => Mixins::where('id', 1)->first()]);
    }
    public function printFromAndroid($id)
    {
        DB::connection()->disableQueryLog();
        $bill = Bill::where('is_deleted', false)->with(['billType', 'customer', 'user', 'payMethods', 'returns',])->where('bill_no', $id)->first();
        return view('printFromAndroid')->with(['bill' => $bill, 'mixins' => Mixins::where('id', 1)->first()]);
    }
    public function indexdir($id)
    {
        DB::connection()->disableQueryLog();
        $bill = Bill::where('is_deleted', false)->with(['billType', 'customer', 'user',])->where('bill_no', $id)->first();
        return view('testdir')->with(['bills' => $bill, 'mixins' => Mixins::where('id', 1)->first()]);
    }
    public function sendToView($id)
    {
        DB::connection()->disableQueryLog();

        $bill = TableBill::with(['tableType' => function ($q) {
            $q->where('is_print', false);
        }, 'customer', 'user', 'table'])->where('table_id', $id)->first();
        // return response()->json($bill);
        return view('test')->with(['bills' => $bill]);
    }
}
