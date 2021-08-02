<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'doer_id' => $faker->numberBetween(1, 10),
    'task_id' => $faker->numberBetween(1, 10),
    'comment' => $faker->text,
    'budget' => $faker->numberBetween(100, 10000),
    'is_refused' => 0
];
