<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'message' => $faker->text,
    'published_at' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
    'writer_id' => $faker->numberBetween(1, 10),
    'recipient_id' => $faker->numberBetween(1, 10),
    'task_id' => $faker->numberBetween(11, 30),
    'unread' => $faker->numberBetween(0, 1),
];
