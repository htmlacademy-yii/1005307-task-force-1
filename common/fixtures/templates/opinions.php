<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'doer_id' => $faker->numberBetween(1, 10),
    'client_id' => $faker->numberBetween(1, 10),
    'task_id' => $faker->numberBetween(11, 30),
    'completion' => $faker->numberBetween(0, 1),
    'description' => $faker->text,
    'rate' => $faker->randomFloat($nbMaxDecimals = 2, $min = 3, $max = 5),

];
