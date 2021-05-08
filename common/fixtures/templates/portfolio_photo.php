<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'photo' => $faker->file($sourceDir = 'frontend/web/img/', $targetDir = 'frontend/web/img1/'),
    'user_id' => $faker->numberBetween(1, 40),
];
