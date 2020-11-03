<?php


namespace App\Logic;


class ExcelDataLogic
{

    private $data         = array();

    private $notEmptyData = array();

    public function __construct(array $data){
        $this->data = $data;
        $this->notEmptyData = $this->dealLineEmptyData($data);
    }

    //处理整都是空的数据
    private function dealLineEmptyData($data){
        $dataArray = $data;
        $boolArray = [];
        foreach ($dataArray as $key=>$values){
            $boolArray[$key] = true;
            $count = count($values);
            $add = 0;
            foreach ($values as $value){
                if(empty($values) || $value == null) $add++;
            }
            if($count==$add){
                $boolArray[$key] = false;
            }
        }
        foreach ($boolArray as $k=>$v){
            if($v == false){
                unset($dataArray[$k]);
            }
        }
        return array_values($dataArray);
    }

    //获取一级目录
    public function getPrimaryDirectory(){
        $dataArray = $this->notEmptyData;
        $primaryArray = [];
        foreach ($dataArray as $k=>$v){
            if($k>0 && $v[0]!=null){
                $primaryArray []= $v[0];
            }
        }
        return $primaryArray;
    }

    //获取二级目录
    public function getSecondaryDirectory($primaryArray){
        $dataArray = $this->notEmptyData;
        $SecondaryData = [];
        foreach ($primaryArray as $value){
            $setKey = 1000;
            foreach ($dataArray as $k=>$v){
                if($v[0] == $value){
                    $SecondaryData[$value] []= $v[1];
                    $setKey = $k;
                }
                if($k>$setKey){
                    if($v[0] == null && $v[1] != null){
                        $SecondaryData[$value] []= $v[1];
                    }
                    if($v[0] !=null) break;
                }
            }
        }
        return $SecondaryData;
    }


    //获取三级目录
    public function getThirdDirectory($SecondaryData){
        $dataArray = $this->notEmptyData;
        $ThirdData = [];
        foreach ($SecondaryData as $key=>$values){
            foreach ($values as $value){
                $setKey = 1000;
                foreach ($dataArray as $k=>$v){
                    $len = count($v);
                    if($v[1] == $value){
                        $ThirdData[$key][$value] []= array_slice($v,2,$len-2);
                        $setKey = $k;
                    }
                    if($k>$setKey){
                        if($v[1] == null){
                            $ThirdData[$key][$value] []= array_slice($v,2,$len-2);
                        }
                        if($v[1] !=null) break;
                    }
                }

            }
        }
        return $ThirdData;
    }

}
