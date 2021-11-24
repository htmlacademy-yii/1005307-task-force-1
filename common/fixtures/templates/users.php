<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'about' => $faker->text,
    'avatar' => 'man-glasses.jpg',
    'bd' => $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-10 years', $timezone = null)->format('Y-m-d'),
    'city_id' => $faker->numberBetween(1, 2),
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'email' => $faker->email,
    'last_activity_time' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'name' => $faker->name,
    'password' => $faker->password,
    'phone' => $faker->e164PhoneNumber,
    'skype' => $faker->word,
    'telegram' => $faker->word,
];
