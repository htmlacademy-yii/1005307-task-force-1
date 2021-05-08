<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'user_id' => $faker->numberBetween(1, 40),
    'favourite_person_id'  => $faker->numberBetween(1, 40),
];
