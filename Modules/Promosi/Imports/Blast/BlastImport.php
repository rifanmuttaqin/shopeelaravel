<?php

namespace Modules\Promosi\Imports\Blast;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BlastImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        return $rows;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

}