<?php

namespace App\Helpers;

use Carbon\Carbon;

class ThaiHelper
{
    public static function number($number)
    {
        return strtr($number, [
            '0' => '๐',
            '1' => '๑',
            '2' => '๒',
            '3' => '๓',
            '4' => '๔',
            '5' => '๕',
            '6' => '๖',
            '7' => '๗',
            '8' => '๘',
            '9' => '๙',
        ]);
    }


    public static function date($date)
    {
        if (!$date) {
            return '';
        }

        $d = Carbon::parse($date);

        $months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];

        return self::number($d->day)
            . ' ' . $months[$d->month]
            . ' พ.ศ. '
            . self::number($d->year + 543);
    }
}
