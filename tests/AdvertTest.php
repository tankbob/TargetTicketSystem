<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TargetInk\User;

class AdvertTest extends TestCase
{
    public function testTicketCreation()
    {
        $user = factory(TargetInk\User::class)->create();
        $user->adverts()->save(factory(TargetInk\Advert::class)->make());

        $admin = factory(TargetInk\User::class, 'admin')->create();

        // Run the tests
        $this->visit('/')
             // Add an avert
             ->type($admin->email, 'email')
             ->type('secret', 'password')
             ->press('Login')
             ->seePageIs('/')
             ->see('Click here to manage adverts displayed to clients')
             ->visit('adverts/' . $user->id)
             ->see('Sample Advert')

             // Check if it exists
             ->click('Logout')
             ->visit('auth/login')
             ->type($user->email, 'email')
             ->type('secret', 'password')
             ->press('Login')
             ->see('class="sponsor"')
             ->see('skyscraper-example.gif')

             // Logout
             ->click('Logout')
             ->seePageIs('auth/login')
             ;

        // Remove users from database
        $user->delete();
        $admin->delete();
    }

}
