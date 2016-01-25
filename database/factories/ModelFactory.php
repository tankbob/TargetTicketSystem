<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(TargetInk\User::class, function (Faker\Generator $faker) {

	$company = $faker->company;
    $company_slug = strtolower(str_replace(' ', '_', $company));
    $company_slug = str_replace(',', '', $company_slug);
    $company_slug = str_replace('.', '', $company_slug);

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'remember_token' => str_random(10),
        'company' => $company,
        'company_slug' => $company_slug,
        'web' => $faker->domainName,
        'admin' => false,
        'password' => bcrypt('secret'),
        'instant' => sha1($faker->name . $faker->email . $company),
    ];
});

$factory->defineAs(TargetInk\User::class, 'admin', function ($faker) use ($factory) {
    $user = $factory->raw(TargetInk\User::class);

    return array_merge($user, ['admin' => true]);
});

$factory->define(TargetInk\Advert::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Sample Advert',
        'url' => 'http://www.example.com',
        'image' => 'skyscraper-example.gif',
    ];
});
