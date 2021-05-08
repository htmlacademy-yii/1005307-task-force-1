<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'title' => $faker->name,
    'is_view' => $faker->numberBetween(1, 2),
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'type' => $faker->name,
    'user_id' => $faker->numberBetween(1, 40),
    'task_id' => $faker->numberBetween(1, 40),
];
