<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'email' => $faker->email,
    'name' => $faker->name,
    'password' => $faker->password,
    'dt_add' => $faker->date,
    'user_role_id' => $faker->numberBetween(1, 2),
    'address' => $faker->streetAddress,
    'bd' => $faker->date,
    'avatar' => 'man-glasses.jpg',
    'about' => $faker->text,
    'phone' => $faker->e164PhoneNumber,
    'skype' => $faker->word,
    'telegram' => $faker->word,
    'rate' => $faker->randomFloat($nbMaxDecimals = 2, $min = 2, $max = 5),
    'city_id' => $faker->numberBetween(1, 10),
    'last_activity_time' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'finished_task_count' => $faker->numberBetween(0, 40),
    'opinions_count'  => $faker->numberBetween(0, 40),
];
