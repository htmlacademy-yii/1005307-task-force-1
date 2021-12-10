<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'client_id' => $faker->numberBetween(1, 10),
    'completion' => $faker->numberBetween(0, 1),
    'description' => $faker->text,
    'doer_id' => $faker->numberBetween(1, 10),
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'rate' => $faker->numberBetween(1, 5),
    'task_id' => $faker->numberBetween(11, 30),
];
