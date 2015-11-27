<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use TargetInk\User;
use TargetInk\Ticket;
use TargetInk\Advert;

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

        $letters = range('a', 'j');
        foreach ($letters as $l) {
            User::create([
                'name' => $l.$l.$l.' '.$l.$l.$l,
                'email' => $l.'@'.$l.'.'.$l,
                'company' => $l.$l.'Centrix',
                'company_slug' => $l.$l.'centrix',
                'web' => 'www.'.$l.".co.uk",
                'admin' => ($l == 'b'),
                'password' => bcrypt('123456')
            ]);
            if($l != 'b'){
                for($i = 1; $i < rand(1, 6); $i++){
                    Ticket::create([
                        'title' => 'Ticket '.$i,
                        'client_id' => User::where('email', $l.'@'.$l.'.'.$l)->first()->id
                    ]);
                }
                for($i = 1; $i < rand(1, 6); $i++){
                    Advert::create([
                        'name' => 'Advert '.$i,
                        'client_id' => User::where('email', $l.'@'.$l.'.'.$l)->first()->id,
                        'url' => 'http://www.google.es'
                    ]);
                }
            }
        }

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
