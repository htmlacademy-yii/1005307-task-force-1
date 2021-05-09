<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'title' => $faker->name,
    'description' => $faker->text,
    'rate' => $faker->randomFloat($nbMaxDecimals = 2, $min = 3, $max = 5),
    'writer_id' => $faker->numberBetween(1, 20),
    'task_id' => $faker->numberBetween(1, 40),
];
