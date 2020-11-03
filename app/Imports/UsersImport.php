<?php

namespace App\Imports;

use App\Exceptions\ApiException;
use App\Logic\ExcelDataLogic;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return array
     */

    public function collection(Collection $collection){
        $dataArray = $collection->toArray();
        $excelDataObj = new ExcelDataLogic($dataArray);
        $primaryData = $excelDataObj->getPrimaryDirectory();
        $SecondaryData = $excelDataObj->getSecondaryDirectory($primaryData);
        $ThirdData =$excelDataObj->getThirdDirectory($SecondaryData);
        var_dump($ThirdData);
    }
}
