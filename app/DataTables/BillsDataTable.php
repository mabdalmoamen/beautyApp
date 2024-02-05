<?php

namespace App\DataTables;

use App\Models\Bill;
use App\Models\Mixins;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function PHPUnit\Framework\isEmpty;

class BillsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bill $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $closure_hour = Mixins::where('id', 1)->first();
        $mytime = Carbon::now();
        App::setLocale($closure_hour->default_lang);
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        $Bills = null;
        if (request()->has('user_id') && request('user_id') != '' ) {
            if (request()->has('cust_id') && request('cust_id') != '') {
                if (request()->has('pay') && request('pay') != '') {
                    $Bills = $this->isUserCustomerAndPayMethod($today);
                } else {
                    $Bills = $this->isUserAndCustomer($today);
                }
            } else {
                if (request()->has('pay') && request('pay') != '') {
                    $Bills = $this->isUserAndPayMethod($today);
                } else {
                    $Bills = $this->isUser($today);
                }
            }
        } else if (request()->has('cust_id') && request('cust_id') != '') {
            if (request()->has('pay') && request('pay') != '') {
                $Bills = $this->isCustomerAndPayMethod($today);
            } else {
                $Bills = $this->isCustomer($today);
            }
        } else if (request()->has('pay') && request('pay') != '') {
            $Bills = $this->isPayMethod($today);
        } else {
            $Bills = $this->isDefault($today);
        }

        return $Bills;
    }
    private function isCustomer($today)
    {
        $Bill = null;
        $closure_hour = Mixins::where('id', 1)->first();
        $mytime = Carbon::now();
        App::setLocale($closure_hour->default_lang);
        $hour = $mytime->toArray()['hour'];
        if ($hour < $closure_hour->closure_hour) {
            $today =
                Carbon::yesterday()->setTime($closure_hour->closure_hour, 0);
        } else {
            $today = Carbon::today()->setTime($closure_hour->closure_hour, 0);
        }
        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('cust_id', request('cust_id'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('cust_id', request('cust_id'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('cust_id', request('cust_id'));
        }

        return $Bill;
    }
    private function isCustomerAndPayMethod($today)
    {
        $Bill = null;
        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        }

        return $Bill;
    }
    private function isUser($today)
    {
        $Bill = null;
        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('user_id', request('user_id'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('user_id', request('user_id'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '') {
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('user_id', request('user_id'));
            }
        }

        return $Bill;
    }
    private function isUserCustomerAndPayMethod($today)
    {
        $Bill = null;
        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('user_id', request('user_id'))->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('user_id', request('user_id'))->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        } else {
            if (request()->has('from') && request('from') != ''  && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('user_id', request('user_id'))->where('cust_id', request('cust_id'))->where('bill_paid_type', request('pay'));
        }

        return $Bill;
    }
    private function isUserAndPayMethod($today)
    {
        $Bill = null;

        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('user_id', request('user_id'))->where('bill_paid_type', request('pay'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('user_id', request('user_id'))->where('bill_paid_type', request('pay'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('user_id', request('user_id'))->where('bill_paid_type', request('pay'));
        }

        return $Bill;
    }
    private function isUserAndCustomer($today)
    {
        $Bill = null;

        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('user_id', request('user_id'))->where('cust_id', request('cust_id'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('user_id', request('user_id'))->where('cust_id', request('cust_id'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('user_id', request('user_id'))->where('cust_id', request('cust_id'));
        }

        return $Bill;
    }
    private function isPayMethod($today)
    {
        $Bill = null;
        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today)->where('bill_paid_type', request('pay'));
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'))->where('bill_paid_type', request('pay'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'))->where('bill_paid_type', request('pay'));
        }

        return $Bill;
    }
    private function isDefault($today)
    {
        $Bill = null;

        if (request('period') == "daily") {
            $time =
                $today;
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {

                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->where('bill_date', '>=',  $today);
        } else if (request('period') == "monthly") {
            $Bill = Bill::with(['sale', 'user' => function ($q) {
                $q->select('id', 'name');
            }, 'customer' => function ($q) {
                $q->select('cust_id', 'cust_name');
            }, 'payMethods'])
                ->whereMonth('bill_date', date('m'));
        } else {
            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $Bill = Bill::with(['sale', 'user' => function ($q) {
                    $q->select('id', 'name');
                }, 'customer' => function ($q) {
                    $q->select('cust_id', 'cust_name');
                }, 'payMethods'])
                    ->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'));
        }

        return $Bill;
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $mixins = Mixins::where('id', 1)->first();
        return $this->builder()
            ->setTableId('bills-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)->pageLength(20)
            ->buttons(
                // Button::make('create'),
                Button::make('excel'),
                Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')

            )->language(['url' => $mixins->default_lang == "ar" ?
                '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json'
                : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $mixins = Mixins::where('id', 1)->first();
        return [
            Column::make('bill_no'),
            Column::make('bill_sum')->title(__($mixins->default_lang == "ar" ? 'ar.Sum' : 'Sum'))->addClass('sum'),
            Column::make('bill_vat_val')->title(__($mixins->default_lang == "ar" ? 'ar.Vat' : 'Vat')),
            Column::make('bill_total')->title(__($mixins->default_lang == "ar" ? 'ar.Total' : 'Total')),
            Column::make('customer.cust_name')->title(__($mixins->default_lang == "ar" ? 'ar.name' : 'name')),
            Column::make('pay_methods.pay_method_name')->title(__($mixins->default_lang == "ar" ? 'طريقة الدفع' : 'Pay Method')),
            Column::make('user.name')->title('user name'),
            Column::make('bill_discount_percent'),
            Column::make('offer_discount'),
            Column::make('bill_discount'),
            Column::make('bill_extra'),
            Column::make('sale_type'),
            Column::make('sale_discount'),
            Column::make('bill_date'),
            Column::make('bill_paid_val'),
            Column::make('bill_remain_val'),
            Column::make('bill_notes'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Bills_' . date('YmdHis');
    }
}
