<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 15.01.2017
 * Time: 22:43
 */

namespace app\models;


class BeautyDate extends \DateTime
{
    private static function getNowYear()
    {
        return date('Y', time());
    }

    private static function getNowMonth()
    {
        return date('m',time());
    }


    /**
     * Отдаёт дату этого месяца
     * @return false|int|string
     */
    public static function getThisMonth()
    {
        $nowYear = BeautyDate::getNowYear();
        $nowMonth = BeautyDate::getNowMonth();

        $datetime = new \DateTime();
        $nowMonth = $datetime->setDate($nowYear,$nowMonth,1)->getTimestamp();

        return $nowMonth;
    }

    /**
     * Отдаёт дату прошлого месяца
     * @return false|int
     */
    public static function getLastMonth()
    {
        $nowYear = BeautyDate::getNowYear();
        $nowMonth = BeautyDate::getNowMonth();

        $datetime = new \DateTime();
        $now = $datetime->setDate($nowYear,$nowMonth,1)->getTimestamp();
        $lastMonth = strtotime('last month',$now);

        return $lastMonth;
    }

    /**
     * Отдаёт дату прошлого месяца
     * @return false|int
     */
    public static function getLastYear()
    {
        $nowYear = BeautyDate::getNowYear();

        $datetime = new \DateTime();
        $now = $datetime->setDate($nowYear,1,1)->getTimestamp();
        $lastYear = strtotime('last year',$now);

        return $lastYear;
    }

    /**
     * Конвертирует из 1480628126 в '2016-12-01 23:35:26'.
     * @param $date
     * @return false|string
     */
    public static function getBeautyDate($date)
    {
        return date('Y-m-d H:i:s',$date);
    }
}