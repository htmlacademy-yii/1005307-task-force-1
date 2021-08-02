<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'category_id' => $faker->numberBetween(1, 8),
    'city_id' => $faker->numberBetween(1, 2),
    'doer_id' => $faker->numberBetween(1, 10),
    'client_id' => $faker->numberBetween(1, 10),
    'name' => $faker->name,
    'description' => $faker->text,
    'expire' => $faker->dateTimeThisYear($min = 'now', $max = '+1 year')->format('Y-m-d H:i:s'),
    'address' => $faker->streetAddress,
    'budget' => $faker->numberBetween(1, 10000),
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude,
    'location_comment' => $faker->name,
    'status_task' => 'new'
];
