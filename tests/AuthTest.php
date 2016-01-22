<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TargetInk\User;

class AuthTest extends TestCase
{
    public function testLoginClient()
    {
        $user = factory(TargetInk\User::class)->create();
        $admin = factory(TargetInk\User::class, 'admin')->create();

        $this->seeInDatabase('users', ['email' => $user->email]);
        $this->seeInDatabase('users', ['email' => $admin->email]);

        // Run the tests
        $this->visit('/')
             ->seePageIs('auth/login')
             ->see('Login')
             ->see('Reset password')
             ->press('Login')
             ->see('There were some problems with your input')
             ->type('asdf', 'email')
             ->type('asdf', 'password')
             ->press('Login')
             ->see('There were some problems with your input')
             ->type('a@a.com', 'email')
             ->type('asdf', 'password')
             ->press('Login')
             ->see('These credentials do not match our records')

             // User Login
             ->type($user->email, 'email')
             ->type('secret', 'password')
             ->press('Login')
             ->seePageIs('/')
             ->see('CHOOSE A SERVICE')
             ->see('Maintenance & Support')
             ->see('SEO Documents')
             ->see('Information Documents')
             ->dontSee('Create a new client')
             ->dontSee('Click here to manage adverts')

             // Logout
             ->click('Logout')
             ->seePageIs('auth/login')

             // Admin Login
             ->type($admin->email, 'email')
             ->type('secret', 'password')
             ->press('Login')
             ->seePageIs('/')
             ->see('Click here to manage adverts')
             ->see('Create a new client')
             ->see('SEO Documents')
             ->see('Information Documents')
             ->see('Welcome to Support Administration Hub')
             ;

        // Remove user from database
        $user->delete();

        // Remove admin from database
        $admin->delete();
    }

    public function testRegisterFails()
    {
        $response = $this->call('GET', 'auth/register');
        $this->assertEquals(404, $response->status());

        $response = $this->call('POST', 'auth/register');
        $this->assertEquals(302, $response->status());
    }
}
