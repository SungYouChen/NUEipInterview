<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class GetCollectionImport implements ToCollection
{
    use Importable;

    /**
     * @param  Collection  $collection
     *
     * @return void
     */

    public function collection(Collection $collection)
    {
    }
}
