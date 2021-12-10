<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'address' => $faker->streetAddress,
    'budget' => $faker->numberBetween(1, 10000),
    'category_id' => $faker->numberBetween(1, 8),
    'city_id' => $faker->numberBetween(1, 2),
    'client_id' => $faker->numberBetween(1, 10),
    'description' => $faker->text,
    'doer_id' => $faker->numberBetween(1, 10),
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'expire' => $faker->dateTimeThisYear($min = 'now', $max = '+1 year')->format('Y-m-d H:i:s'),
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude,
    'name' => $faker->name,
    'status_task' => 'Новое',
];
