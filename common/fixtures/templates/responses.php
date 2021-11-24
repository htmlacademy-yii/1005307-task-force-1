<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'budget' => $faker->numberBetween(100, 10000),
    'comment' => $faker->text,
    'doer_id' => $faker->numberBetween(1, 10),
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'is_refused' => 0,
    'task_id' => $faker->numberBetween(1, 10),
];
