<?php

namespace App\Http\Controllers;

use App\DataTables\BillsDataTable;
use App\DataTables\TypeDataTable;
use App\DataTables\UsersDataTable;
use App\Models\Customer;
use App\Models\Mixins;
use App\Models\PayMethods;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class BillController extends Controller
{
    public function index(BillsDataTable $dataTable)
    {

        if ($dataTable->query()) {
            return $dataTable
                ->render('bills', ['mixins' => Mixins::where('id', 1)->first(), 'bill_total' => $dataTable->query()->sum('bill_total'), 'sum' => $dataTable->query()->sum('bill_sum'), 'vat' => $dataTable->query()->sum('bill_vat_val'), 'pays' => PayMethods::get(), 'customers' => Customer::get(), 'users' => User::where('id', '!=', -1)->get()]);
        }
        return $dataTable
            ->render('bills', ['mixins' => Mixins::where('id', 1)->first(), 'pays' => PayMethods::get(), 'customers' => Customer::get(), 'users' => User::where('id', '!=', -1)->get()]);
    }
    public function item()
    {
        return response()->json(Type::with('typeStock', 'units')->where('is_deleted', false)->get());
    }
    public function update()
    {
        return view('version');
    }
    public function updated()
    {
        DB::connection()->disableQueryLog();
        $mixins = Mixins::where('id', 1)->first();
        $startDate = strtotime(date('Y-m-d', strtotime($mixins->end_support_date)));
        $currentDate = strtotime(date('Y-m-d'));

        if ($startDate > $currentDate) {
            // && composer update --ignore-platform-req=ext-bolt && npm install
            shell_exec("git reset --hard && git pull  && npm run prod ");
            $res = 'تم التحديث بنجاح';
            $path = base_path() . '\app\backup\last.sql';
            $sql = file_get_contents($path);

            try {
                DB::unprepared($sql);
            } catch (\Illuminate\Database\QueryException $ex) {
                // dd($ex->getMessage());
            }
        } else {
            $res = "يرجى التواصل مع الدعم للفني لتجديد الدعم والتحديث";
        }

        return view('version')->with('res', $res);
    }
    public function types(TypeDataTable $dataTable)
    {

        return $dataTable
            ->render('typesToExcel');
    }
}
