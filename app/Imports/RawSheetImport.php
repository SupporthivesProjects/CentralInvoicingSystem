<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class RawSheetImport extends StringValueBinder implements ToArray, WithCustomValueBinder
{
    public function array(array $array)
    {
    }
}