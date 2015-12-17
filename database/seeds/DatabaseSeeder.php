<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use TargetInk\User;
use TargetInk\Ticket;
use TargetInk\Advert;
use TargetInk\Response;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $faker = Faker\Factory::create();

        // Create admin users
        User::create([
            'name' => 'Sample User',
            'email' => 'dev@heliocentrix.co.uk',
            'company' => 'Heliocentrix',
            'company_slug' => 'heliocentrix',
            'web' => 'http://www.heliocentrix.co.uk',
            'admin' => true,
            'password' => bcrypt('secret')
        ]);

        User::create([
            'name' => 'Heliocentrix',
            'email' => 'user@heliocentrix.co.uk',
            'company' => 'Heliocentrix',
            'company_slug' => 'heliocentrix',
            'web' => 'http://www.heliocentrix.co.uk',
            'admin' => false,
            'password' => bcrypt('secret')
        ]);

        User::create([
            'name' => 'Rob Stevens',
            'email' => 'rob@targetink.co.uk',
            'company' => 'Target Ink',
            'company_slug' => 'target_ink',
            'web' => 'http://www.targetink.co.uk',
            'admin' => true,
            'password' => bcrypt('secret')
        ]);

        User::create([
            'name' => 'Sample User',
            'email' => 'user@targetink.co.uk',
            'company' => 'Target Ink',
            'company_slug' => 'target_ink',
            'web' => 'http://www.targetink.co.uk',
            'admin' => false,
            'password' => bcrypt('secret')
        ]);

        $usersToSeed = 25;
        for ($i = 1; $i <= $usersToSeed; $i++) {
            $company = $faker->company;
            $company_slug = strtolower(str_replace(' ', '_', $company));
            $company_slug = str_replace(',', '', $company_slug);
            $company_slug = str_replace('.', '', $company_slug);

            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'company' => $company,
                'company_slug' => $company_slug,
                'web' => $faker->domainName,
                'admin' => false,
                'password' => bcrypt('secret')
            ]);

            // Create tickets
            for($t = 1; $t < rand(1, 6); $t++){
                $ticket = Ticket::create([
                    'title' => $faker->text(80),
                    'client_id' => $user->id,
                ]);

                // Create some responses
                $resAdmin = true;
                for($r = 1; $r < rand(2, 10); $r++) {
                    $response = Response::create([
                        'ticket_id' => $ticket->id,
                        'working_time' => rand(0, 100),
                        'admin' => $resAdmin,
                        'content' => $faker->paragraph
                    ]);

                    if($resAdmin) {
                        $resAdmin = false;
                    } else {
                        $resAdmin = true;
                    }
                }
            }

            // Create some adverts
            for($a = 0; $a < rand(1, 6); $a++){
                Advert::create([
                    'name' => $faker->text(80),
                    'client_id' => $user->id,
                    'url' => 'http://www.google.com',
                    'image' => 'skyscraper-example.gif',
                ]);
            }

        }

        Model::reguard();
    }
}
