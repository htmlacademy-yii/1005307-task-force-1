<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'rate' => $faker->randomFloat($nbMaxDecimals = 2, $min = 3, $max = 5),
    'title' => $faker->name,
    'description' => $faker->text,
    'doer_id' => $faker->numberBetween(1, 10),
    'task_id' => $faker->numberBetween(1, 10)
];
