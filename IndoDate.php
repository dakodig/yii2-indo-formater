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

    public static function now($format='Y-m-d H:i:s')
    {
        $datetime = new \DateTime();
        $datetime->getTimestamp();
        return $datetime->format($format);
    }

    public static function create($datetime,$format = 'Y-m-d H:i:s')
    {
        $datetime = new \DateTime();
        if(preg_match('/[ ]/', $datetime)==1) {
            if(preg_match('/[- :]/', $datetime)==1) {
                $exp = explode(" ", $datetime);
                if (count($exp) == 1) {
                    $exp1 = explode("-", $exp[0]);
                    $result = $datetime->setDate($exp1[0], $exp1[1], $exp1[2])->format($format);
                } else if (count($exp) > 1) {
                    $exp1 = explode("-", $exp[0]);
                    $exp2 = $exp[1];
                    $result = $datetime->setDate($exp1[0], $exp1[1], $exp1[2])->format($format) . ' ' . $exp2;
                }
            }else if(preg_match('/[-]/', $datetime)==1 && preg_match('/[ ]/', $datetime)!=1) {
                $exp = explode("-", $datetime);
                if(count($exp)==2){
                    $result = $datetime->setDate($exp[0], $exp[1],1)->format($format);
                }else{
                    $result = $datetime->setDate($exp[0], $exp[1],$exp[2])->format($format);
                }
            }
        }else{
            $result = $datetime->setDate($datetime)->format($format);
        }

        return $result;
    }
}