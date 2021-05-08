<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'category_id' => $faker->numberBetween(1, 8),
    'description' => $faker->text,
    'expire' =>  $faker->dateTimeThisYear($max = '+1 year')->format('Y-m-d H:i:s'),
    'name' =>  $faker->name,
    'address' => $faker->streetAddress,
    'budget' => $faker->numberBetween(1, 10000),
    'latitude' =>  $faker->latitude,
    'longitude' =>  $faker->longitude,
    'location_comment' =>  $faker->name,
    'city_id' => $faker->numberBetween(1, 10),
    'doer_id'  => $faker->numberBetween(1, 10),
    'client_id' => $faker->numberBetween(1, 10),
    'status_task_id' => $faker->numberBetween(1, 5)
];
