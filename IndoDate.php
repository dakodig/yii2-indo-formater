<?php

namespace dakodig\yii2indoformater;

use yii\base\Model;

class IndoDate extends Model
{
    private static $month_en_to_indo = [
        '' => '',
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember',
        'Jan' => 'Jan',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'Apr' => 'Apr',
        'May' => 'Mei',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Agu',
        'Sep' => 'Sep',
        'Oct' => 'Okt',
        'Nov' => 'Nov',
        'Dec' => 'Des',
    ];

    public function __construct($config = [])
    {
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_ALL, "id_ID.UTF-8");
    }

    public static function now($format = 'Y-m-d H:i:s')
    {
        $datetime = new \DateTime();
        $datetime->getTimestamp();
        if (preg_match('/F/', $format)) {
            $search = $datetime->format('F');
        } else if (preg_match('/M/', $format)) {
            $search = $datetime->format('M');
        } else {
            $search = null;
        }
        if (!empty($search)) {
            $result = str_replace($search, self::$month_en_to_indo[$search], $datetime->format($format));
        } else {
            $result = $datetime->format($format);
        }
        return $result;
    }

    public static function create($datetime, $format = 'Y-m-d H:i:s')
    {
        $detime = new \DateTime($datetime);
        if (preg_match('/F/', $format)) {
            $search = $detime->format('F');
        } else if (preg_match('/M/', $format)) {
            $search = $detime->format('M');
        } else {
            $search = null;
        }

        if (preg_match('/[- :]/', (string)$datetime)) {
            if (preg_match('/[ ]/', (string)$datetime)) {
                $exp = explode(" ", $datetime);
                if (count($exp) == 1) {
                    $exp1 = explode("-", $exp[0]);
                    $result = str_replace($search, self::$month_en_to_indo[$search], $detime->setDate($exp1[0], $exp1[1], $exp1[2])->format($format));
                } else if (count($exp) > 1) {
                    $exp1 = explode("-", $exp[0]);
                    $exp2 = $exp[1];
                    $result = str_replace($search, self::$month_en_to_indo[$search], $detime->setDate($exp1[0], $exp1[1], $exp1[2])->format($format));
                }
            } else if (preg_match('/[-]/', (string)$datetime) && !preg_match('/[ ]/', (string)$datetime)) {
                $exp = explode("-", $datetime);
                if (count($exp) == 2) {
                    $result = str_replace($search, self::$month_en_to_indo[$search], $detime->setDate($exp[0], $exp[1], 1)->format($format));
                } else {
                    $result = str_replace($search, self::$month_en_to_indo[$search], $detime->setDate($exp[0], $exp[1], $exp[2])->format($format));
                }
            }
        } else {
            $result = $detime->setDate($datetime, 1, 1)->format($format);
        }

        return $result;
    }

    public static function addDate($fromDate, $interval = '1 days', $format = 'Y-m-d')
    {
        if (!empty($fromDate)) {
            if (preg_match('/[-]/', (string)$fromDate)) {
                $exp = explode("-", $fromDate);
                $datetime = new \DateTime();
                $nextDate = $datetime->setDate($exp[0], $exp[1], $exp[2])
                    ->add(\DateInterval::createFromDateString($interval));
                $result = $nextDate->format($format);
                return $result;
            } else {
                echo 'Maaf, Format tanggal salah!';
            }
        } else {
            echo 'Maaf, tanggal asal belum diisi!';
        }
    }
}