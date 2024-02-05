<?php

namespace App\DataTables;

use App\Models\Mixins;
use App\Models\Type;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TypeDataTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('action', 'type.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Type $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Type $model)
    {
        return $model->newQuery();
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
            // ->orderBy(0)->pageLength(20)
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
            Column::make('type_name_ar')->title($mixins->default_lang == "ar" ? 'اسم الصنف ' : 'Type Name'),
            Column::make('type_sill_price')->title($mixins->default_lang == "ar" ? 'سعر البيع ' : 'Sill Price '),
            Column::make('type_purchases_price')->title($mixins->default_lang == "ar" ? 'سعر الشراء ' : 'Ppurchases Price'),

        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Type_' . date('YmdHis');
    }
}
