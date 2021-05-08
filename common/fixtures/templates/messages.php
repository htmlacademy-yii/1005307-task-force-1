<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'text' => $faker->text,
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'writer_id' => $faker->numberBetween(1, 10),
    'task_id' => $faker->numberBetween(1, 10),
];
