<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'file_item' => $faker->file($sourceDir = 'frontend/web/img/', $targetDir = 'frontend/web/img1/'),
    'task_id' => $faker->numberBetween(1, 40),
];
