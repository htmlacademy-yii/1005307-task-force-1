<?php

namespace frontend\components;

use \yii\i18n\formatter;

class MyFormatter extends Formatter
{
    /**
     * @param int $number
     * @param string $one
     * @param string $two
     * @param string $many
     * @return string
     */
    public function getNounPluralForm(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 20):
                return $many;

            case ($mod10 > 5):
                return $many;

            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    /**
     * @param $date
     * @return false|float
     */
    public function getAge($date)
    {
        return floor((time() - strtotime($date)) / (60 * 60 * 24 * 365.25));
    }

    /**
     * @param $mark
     * @return string
     */
    public function getRatingType($mark): string
    {
        if ($mark == '5' || $mark == '4') {
            return 'five';
        }

        return 'three';
    }

    public function getPeriodTime($dt)
    {

        $date = new \DateTime($dt);

        $interval = date_create('now')->diff($date);

        if ($interval->y >= 1) {
            return $interval->y . ' ' . $this->getNounPluralForm(intval($interval->y), 'год', 'года', 'лет') . ' на сайте';
        }
        if ($interval->m >= 1) {
            return $interval->m . ' ' . $this->getNounPluralForm(intval($interval->m), 'месяц', 'месяца', 'месяцев') . ' на сайте';
        }
        if ($interval->d >= 1) {
            return $interval->d . ' ' . $this->getNounPluralForm(intval($interval->d), 'день', 'дня', 'дней') . ' на сайте';
        }
        if ($interval->h >= 1) {
            return $interval->h . ' ' . $this->getNounPluralForm(intval($interval->h), 'час', 'часа', 'часов') . ' на сайте';
        }
        if ($interval->i >= 1) {
            return $interval->i . ' ' . $this->getNounPluralForm(intval($interval->i), 'минута', 'минуты', 'минут') . ' на сайте';
        }
        return $interval;
    }

}
