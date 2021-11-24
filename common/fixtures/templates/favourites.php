<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'dt_add' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'favourite_person_id' => $faker->numberBetween(1, 20),
    'user_id' => $faker->numberBetween(1, 20),
];
