<?php

namespace htmlacademy\helpers;

use DateTime;

class SiteHelper
{
    public static function array_first($array, $default = null)
    {
        foreach ($array as $item) {
            return $item;
        }
        return $default;
    }

    /**
     * Выбирает слово с правильными окончанием после числительного.
     *
     * @param int $number число
     * @param array $words варианты склонений ['яблоко', 'яблока', 'яблок']
     * @return string
     */
    public static function plural($number, $words)
    {
        return $words[($number % 100 > 4 && $number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][min($number % 10, 5)]];
    }

    /**
     * '%Y years %m months %d days %H hours %i minutes %s seconds'
     * @param $date1
     * @param $date2
     * @param string $differenceFormat
     * @return string
     * @throws \Exception
     */
    public static function dateDifference($date1, $date2, $differenceFormat = '%a')
    {
        $date1 = date("Y-m-d", $date1);
        $date1 = new DateTime($date1);
        $date2 = date("Y-m-d", $date2);
        $date2 = new DateTime($date2);
        $interval = $date1->diff($date2);
        return $interval->format($differenceFormat);
    }

    public static function getUserUrl($user)
    {
        $userUrl = "/users/user/" . $user->id;
        if (isset($user->profile)) {
            $userUrl = "/users/" . $user->id;
        }

        return $userUrl;
    }

    public static function getUserAvatar($path)
    {
        $emailRegExp = "/^(https?:\/\/)/";
        $url = "/uploads/user-images/" . $path;
        if (preg_match($emailRegExp, $path)) {
            $url = $path;
        }

        return $url;
    }

}
