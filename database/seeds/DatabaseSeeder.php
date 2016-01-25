<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use TargetInk\User;
use TargetInk\Ticket;
use TargetInk\Advert;
use TargetInk\Response;
use TargetInk\Attachment;
use TargetInk\File;

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
            'name' => 'Heliocentrix Admin',
            'email' => 'dev@heliocentrix.co.uk',
            'company' => 'Heliocentrix',
            'company_slug' => '',
            'web' => 'http://www.heliocentrix.co.uk',
            'admin' => true,
            'password' => bcrypt('secret'),
            'instant' => sha1('Heliocentrix Admin' . 'dev@heliocentrix.co.uk' . 'Heliocentrix'),
        ]);

        User::create([
            'name' => 'Heliocentrix',
            'email' => 'user@heliocentrix.co.uk',
            'company' => 'Heliocentrix',
            'company_slug' => 'heliocentrix',
            'web' => 'http://www.heliocentrix.co.uk',
            'admin' => false,
            'password' => bcrypt('secret'),
            'instant' => sha1('Heliocentrix' . 'user@heliocentrix.co.uk' . 'Heliocentrix'),
        ]);

        User::create([
            'name' => 'Rob Stevens',
            'email' => 'rob@targetink.co.uk',
            'company' => 'Target Ink',
            'company_slug' => '',
            'web' => 'http://www.targetink.co.uk',
            'admin' => true,
            'password' => bcrypt('secret'),
            'instant' => sha1('Rob Stevens' . 'rob@targetink.co.uk' . 'Target Ink'),
        ]);

        User::create([
            'name' => 'Sample User',
            'email' => 'user@targetink.co.uk',
            'company' => 'Target Ink',
            'company_slug' => 'target_ink',
            'web' => 'http://www.targetink.co.uk',
            'admin' => false,
            'password' => bcrypt('secret'),
            'instant' => sha1('Sample User' . 'user@targetink.co.uk' . 'Target Ink'),
        ]);

        $usersToSeed = 25;
        for ($i = 1; $i <= $usersToSeed; $i++) {
            $user = factory(TargetInk\User::class)->make();
            $user->save();

            // Create tickets
            for($t = 1; $t < rand(1, 6); $t++){
                $ticket = Ticket::create([
                    'title' => $faker->text(80),
                    'client_id' => $user->id,
                    'type' => rand(1, 4)
                ]);

                // Create some responses
                $resAdmin = true;
                for($r = 1; $r < rand(2, 10); $r++) {
                    $response = Response::create([
                        'ticket_id' => $ticket->id,
                        'working_time' => rand(0, 100),
                        'admin' => $resAdmin,
                        'content' => $faker->paragraph,
                    ]);

                    if($resAdmin) {
                        $resAdmin = false;
                    } else {
                        $resAdmin = true;
                    }

                    // Add some attachments
                    for($a = 1; $a < rand(2, 4); $a++) {
                        $attachment = Attachment::create([
                            'response_id' => $response->id,
                            'original_filename' => 'pattern_test.jpg',
                            'filename' => 'pattern_test.jpg',
                            'type' => 'I',
                        ]);
                    }
                    for($a = 1; $a < rand(2, 4); $a++) {
                        $attachment = Attachment::create([
                            'response_id' => $response->id,
                            'original_filename' => 'Sample.docx',
                            'filename' => 'Sample.docx',
                            'type' => 'D',
                        ]);
                    }

                }
            }

            // Create some adverts
            for($a = 0; $a < rand(0, 6); $a++){
                Advert::create([
                    'name' => $faker->text(80),
                    'client_id' => $user->id,
                    'url' => 'http://www.google.com',
                    'image' => 'skyscraper-example.gif',
                ]);
            }

            // Create some documents
            for($d = 0; $d < rand(0, 6); $d++){
                File::create([
                    'filename' => $faker->text(30),
                    'filepath' => 'Sample.docx',
                    'client_id' => $user->id,
                    'type' => 'seo',
                ]);
            }
            for($d = 0; $d < rand(0, 6); $d++){
                File::create([
                    'filename' => $faker->text(30),
                    'filepath' => 'Sample.docx',
                    'client_id' => $user->id,
                    'type' => 'info',
                ]);
            }

        }

        Model::reguard();
    }
}
