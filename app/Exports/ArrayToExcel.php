<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArrayToExcel implements WithHeadings, ShouldAutoSize
{

    private mixed $array;
    private mixed $column;

    public function __construct($array, $column)
    {
        $this->array  = $array;
        $this->column = $column;
    }

    public function headings(): array
    {
        $res_array = $this->array;
        array_unshift($res_array, $this->column);

        return $res_array;
    }
}
