<?php

namespace dakodig\yii2indoformater;

use yii\base\Component;

class IndoCurrency extends Component
{

    public $th = ['', 'Ribu', 'Juta', 'Milyar', 'Triliun'];
    public $dg = ['Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'];
    public $tn = ['Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'];
    public $tw = ['Dua Puluh', 'Tiga Puluh', 'Empat Puluh', 'Lima Puluh', 'Enam Puluh', 'Tujuh Puluh', 'Delapan Puluh', 'Sembilan Puluh'];

    public function Rupiah($value) {
        $result = '';
        $vr = explode('.', $value);
        $vrKoma = empty($vr[1]) ? '' : (string) ((strlen($vr[1]) == 1) ? $vr[1] . '0' : $vr[1]);
        $s = (string) $vr[0];
        $s = str_replace('/[\, ]/g', '', $s);
        if (!floatval($s)) {
            $result = 'Not a number.';
        }
        $x = strlen($s);
        if ($x <= 14) {
            $n = str_split($s);
            $str = '';
            $sk = 0;
            for ($i = 0; $i < $x; $i++) {
                if (($x - $i) % 3 == 2) {
                    if ($n[$i] == '1') {
                        $str = $str . $this->tn[$n[$i + 1]] . ' ';
                        $i++;
                        $sk = 1;
                    } else if ($n[$i] != 0) {
                        $str = $str . $this->tw[$n[$i] - 2] . ' ';
                        $sk = 1;
                    }
                } else if ($n[$i] != 0) {
                    $str = $str . $this->dg[$n[$i]] . ' ';
                    if (($x - $i) % 3 == 0)
                        $str = $str . 'Ratus ';
                    $sk = 1;
                }
                if (($x - $i) % 3 == 1) {
                    if ($sk)
                        $str = $str . $this->th[($x - $i - 1) / 3] . ' ';
                    $sk = 0;
                }
            }
            if ($x != strlen($s)) {
                $y = strlen($s);
                $str = $str . 'point ';
                for ($i = $x + 1; $i < $y; $i++)
                    $str = $str . $this->dg[$n[$i]] . ' ';
            }
            $str = str_replace('/[\, ]/g', ' ', $str);
            //Satu Ratus & Seratus
            $str = str_replace("Satu Ratus", "Seratus", $str);
            //Satu Ribu & Seribu
            if ($x > 6) {
                if ($n[1] == 0 && $n[2] == 0) {
                    $str = str_replace("Satu Ribu", "Seribu", $str);
                }
            } else {
                if ($x == 4) {
                    $str = str_replace("Satu Ribu", "Seribu", $str);
                }
            }
            //Satu Puluh & Sepuluh
            $str = str_replace("Satu Puluh", "Sepuluh", $str);
            if (!empty($vrKoma)) {
                $koma = ' ' . $this->Angka($vrKoma) . ' Sen';
            } else {
                $koma = '';
            }
            $result = $str . ' Rupiah' . $koma;
        } else {
            $result = 'Too big.';
        }

        return $result;
    }

}