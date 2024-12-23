<?php

namespace dakodig\yii2indoformater;

use yii\base\Model;

class IndoDate extends Model
{
    public function __construct($config = [])
    {
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_ALL, 'id');
    }

    public static function now()
    {
        $datetime = new \DateTime();
        return $datetime->getTimestamp();
    }

    public static function create($datetime,$format = 'Y-m-d H:i:s')
    {
        $exp = explode(" ", $datetime);
        $datetime = new \DateTime();
        if(count($exp)==1){
            $exp1 = explode("-", $exp[0]);
            $result =  $datetime->setDate($exp1[0],$exp1[1],$exp1[2])->format($format);
        }else if(count($exp)>1){
            $exp1 = explode("-", $exp[0]);
            $exp2 = $exp[1];
            $result = $datetime->setDate($exp1[0],$exp1[1],$exp1[2])->format($format).' '.$exp2;
        }
        return $result;
    }
}