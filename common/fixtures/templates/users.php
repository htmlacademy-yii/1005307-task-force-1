<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'email' => $faker->email,
    'name' => $faker->name,
    'password' => $faker->password,
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'user_role_id' => $faker->numberBetween(1, 2),
    'address' => $faker->streetAddress,
    'bd' => $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-10 years', $timezone = null)->format('Y-m-d'),
    'avatar' => 'man-glasses.jpg',
    'about' => $faker->text,
    'phone' => $faker->e164PhoneNumber,
    'skype' => $faker->word,
    'telegram' => $faker->word,
    'city_id' => $faker->numberBetween(1, 10),
    'last_activity_time' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
];
