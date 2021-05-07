<?php

declare(strict_types=1);

//namespace Frontend\utils;

use Frontend\exceptions\InverseTimeException;

function getPassedTimeSinceLastActivity(string $startingDate): ?string
{
    $passedTime = null;

    $dt_now = date_create();
    $startingDate = date_create($startingDate);
    $dt_diff = date_diff($startingDate, $dt_now);

    if ($dt_diff->invert) {
        throw new InverseTimeException("Дата последней активности пользователя больше текущей даты");
    }

    $minute_endings = [1 => 'у', 2 => 'ы', 3 => 'ы', 4 => 'ы', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => '', 13 => '', 14 => '', 15 => '', 16 => '', 17 => '', 18 => '', 19 => '', 20 => '', 21 => 'у', 22 => 'ы', 23 => 'ы', 24 => 'ы', 25 => '', 26 => '', 27 => '', 28 => '', 29 => '', 30 => '', 31 => 'у', 32 => 'ы', 33 => 'ы', 34 => 'ы', 35 => '', 36 => '', 37 => '', 38 => '', 39 => '', 40 => '', 41 => 'у', 42 => 'ы', 43 => 'ы', 44 => 'ы', 45 => '', 46 => '', 47 => '', 48 => '', 49 => '', 50 => '', 51 => 'у', 52 => 'ы', 53 => 'ы', 54 => 'ы', 55 => '', 56 => '', 57 => '', 58 => '', 59 => ''];
    $hour_endings = [1 => '', 2 => 'а', 3 => 'а', 4 => 'а', 5 => 'ов', 6 => 'ов', 7 => 'ов', 8 => 'ов', 9 => 'ов', 10 => 'ов', 11 => 'ов', 12 => 'ов', 13 => 'ов', 14 => 'ов', 15 => 'ов', 16 => 'ов', 17 => 'ов', 18 => 'ов', 19 => 'ов', 20 => 'ов', 21 => '', 22 => 'а', 23 => 'а'];
    $y = $dt_diff->y;
    $m = $dt_diff->m;
    $d = $dt_diff->d;
    $h = $dt_diff->h;
    $i = $dt_diff->i;

    $dt_yesterday = date_add($dt_now, date_interval_create_from_date_string('yesterday'));

    if (date_format($dt_yesterday, 'Y-m-d') === date_format($startingDate, 'Y-m-d')) {
        $passedTime = 'Вчера, в ' . date_format($startingDate, 'H:i');
    } else {

        if ($y || $m || $d) {
            $passedTime = date_format($startingDate, 'd.m.y в H:i');
        } else {

            if (!$h && !$i) {
                $passedTime = 'только что';
            } else {

                if ($h) {
                    $passedTime = $h . ' час' . $hour_endings[$h] . ' назад';
                } else {
                    $passedTime = $i . ' минут' . $minute_endings[$i] . ' назад';
                }
            }
        }
    }

    return $passedTime;
}

function get_noun_plural_form(int $number, string $one, string $two, string $many): string
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

?>
