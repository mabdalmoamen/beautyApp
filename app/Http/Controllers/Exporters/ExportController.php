<?php
namespace App\Http\Controllers\Exporters;
use App\Http\Controllers\Exporters\UsersExport ;
use Maatwebsite\Excel\Excel;

class ExportController
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function exportViaConstructorInjection()
    {
        return $this->excel->download(new UsersExport, 'users.xlsx');
    }

    public function exportViaMethodInjection(Excel $excel)
    {

        return $excel->download(new UsersExport, 'users.xlsx',
        [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment"]);
    }
}
