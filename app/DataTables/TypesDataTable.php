<?php

namespace App\DataTables;

use App\Models\BillTypes;
use App\Models\Mixins;
use App\Models\Type;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TypesDataTable extends DataTable
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
     * @param \App\Models\Type $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $bills = null;
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

        // if (request()->has('cat_id') && request('cat_id')  != '') {
        //     if (request('period') == "daily") {

        //         $bills = $this->IsDailyCategory($today);
        //     } else if (request('period') == "monthly") {
        //         $bills = $this->isMonthlyCategory();
        //     } else {
        //         $bills = $this->isPeriodCategory();
        //     }
        // } else

        if (request('period') == "daily") {
            $bills = $this->IsDaily($today);
        } else if (request('period') == "monthly") {
            $bills = $this->isMonthly();
        } else  if (request('to')) {
            $bills = $this->isPeriod();
        } else {
            if (request('period') != "period") {
                $bills = BillTypes::with(['type',  'bill' => function ($q) use ($today) {
                    return $q->where('bill_date', '>=',  $today);
                }]);
            }
        }
        return $bills;
    }
    public function isPeriod()
    {
        if (request()->has('type_id') && request('type_id')  != '') {

            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $bills = BillTypes::where('type_id', request('type_id'))->with(['type',  'bill' => function ($q) {
                    return $q->whereDate('bill_date', '>=', request('from'))
                        ->whereDate('bill_date', '<=', request('to'));
                }]);
        } else {

            $bills = BillTypes::with(['type',  'bill' => function ($q) {
                return $q->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'));
            }]);
        }
        return $bills;
    }
    public function isMonthly()
    {
        if (request()->has('type_id') && request('type_id')  != '') {

            $bills = BillTypes::where('type_id', request('type_id'))->with(['type',  'bill' => function ($q) {
                return $q->whereMonth('bill_date', date('m'));
            }]);
        } else {
            $bills = BillTypes::with(
                [
                    'type',  'bill' => function ($q) {
                        return $q->whereMonth('bill_date', date('m'));
                    }
                ]
            );
        }
        return $bills;
    }
    public function IsDaily($today)
    {

        if (request()->has('type_id') && request('type_id')  != '') {
            $bills = BillTypes::where('type_id', request('type_id'))->with(['type',  'bill' => function ($q) use ($today) {
                return $q->where('bill_date', '>=',  $today);
            }]);
        } else {

            $bills = BillTypes::with(['type',  'bill' => function ($q) use ($today) {
                return $q->where('bill_date', '>=',  $today);
            }]);
        }
        return $bills;
    }

    public function isPeriodCategory()
    {
        if (request()->has('type_id') && request('type_id')  != '') {

            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
                $bills = BillTypes::where('type_id', request('type_id'))->with(['type' => function ($q) {
                    return $q->where('main_type',  request('cat_id'));
                },  'bill' => function ($q) {
                    return $q->whereDate('bill_date', '>=', request('from'))
                        ->whereDate('bill_date', '<=', request('to'));
                }]);
        } else {
            $bills = BillTypes::with(['type' => function ($q) {
                return $q->where('main_type',  request('cat_id'));
            },  'bill' => function ($q) {
                return $q->whereDate('bill_date', '>=', request('from'))
                    ->whereDate('bill_date', '<=', request('to'));
            }]);
        }
        return $bills;
    }
    public function isMonthlyCategory()
    {
        if (request()->has('type_id') && request('type_id')  != '') {

            $bills = BillTypes::where('type_id', request('type_id'))->with(['type' => function ($q) {
                return $q->where('main_type',  request('cat_id'));
            },  'bill' => function ($q) {
                return $q->whereMonth('bill_date', date('m'));
            }]);
        } else {
            $bills = BillTypes::with(
                [
                    'type' => function ($q) {
                        return $q->where('main_type',  request('cat_id'));
                    },  'bill' => function ($q) {
                        return $q->whereMonth('bill_date', date('m'));
                    }
                ]
            );
        }
        return $bills;
    }
    public function IsDailyCategory($today)
    {
        if (request()->has('type_id') && request('type_id')  != '') {
            $bills = BillTypes::where('type_id', request('type_id'))->with(['type' => function ($q) {
                return $q->where('main_type',  request('cat_id'));
            },  'bill' => function ($q) use ($today) {
                return $q->where('bill_date', '>=',  $today);
            }]);
        } else {
            $bills = BillTypes::with(['type' => function ($q) {
                return $q->where('main_type',  request('cat_id'));
            },  'bill' => function ($q) use ($today) {
                return $q->where('bill_date', '>=',  $today);
            }]);
        }
        return $bills;
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
            ->setTableId('types-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(7)->pageLength(20)
            ->buttons(
                Button::make('excel'),
                Button::make('print'),
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
            Column::make('type_id')->title($mixins->default_lang == "ar" ? 'كود الصنف ' : 'Type Code'),
            Column::make('type.type_name_ar')->title($mixins->default_lang == "ar" ? 'اسم الصنف ' : 'Type Name'),
            Column::make('type_price')->title($mixins->default_lang == "ar" ? 'سعر البيع بالفاتورة' : 'Sill Price In Bill'),
            Column::make('type_purchases_price')->title($mixins->default_lang == "ar" ? 'سعر الشراء بالفاتورة' : 'Ppurchases Price In Bill'),
            Column::make('type.type_sill_price')->title($mixins->default_lang == "ar" ? 'سعر البيع ' : 'Sill Price '),
            Column::make('type.type_purchases_price')->title($mixins->default_lang == "ar" ? 'سعر الشراء ' : 'Ppurchases Price'),
            Column::make('type.type_stock.mixins_type_stock')->title($mixins->default_lang == "ar" ? 'المخزون' : 'Stock'),
            Column::make('bill_no')->title($mixins->default_lang == "ar" ? 'رقم الفاتورة' : 'Bill No'),
            Column::make('type.type_purchases_price')->title($mixins->default_lang == "ar" ? 'سعر الشراء ' : 'Ppurchases Price'),
            Column::make('bill.bill_date'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Types_' . date('YmdHis');
    }
}
