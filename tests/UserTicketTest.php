<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TargetInk\User;

class UserTicketTest extends TestCase
{
    public function testTicketCreation()
    {
        $user = factory(TargetInk\User::class)->create();

        $ticketName = 'Ticket Sample ' . rand(0, 9999);

        // Run the tests
        $this->visit('/')
             ->type($user->email, 'email')
             ->type('secret', 'password')
             ->press('Login')
             ->seePageIs('/')

             // Tickets
             ->visit($user->company_slug . '/tickets')
             ->see('There are no tickets to show')

             // Create a ticket
             ->click('CREATE A NEW TICKET')
             ->seePageIs($user->company_slug . '/tickets/create')
             ->see('CHOOSE A TICKET')
             ->type($ticketName, 'title')
             ->type('Test ticket', 'content')
             ->press('submit')
             ->see('SUBMISSION SUCCESS')
             ->visit($user->company_slug . '/tickets')
             ->see($ticketName)
             ->see('Web Amends')

             // Check archives
             ->visit($user->company_slug . '/tickets?archived=1')
             ->see('There are no tickets to show')

             // Add the ticket to archive
             ->visit($user->company_slug . '/tickets')
             ->click('archive-ticket')
             ->see('The ticket has been successfully archived')
             ->visit($user->company_slug . '/tickets?archived=1')
             ->see($ticketName)

             // Take it out of the archive
             ->click('unarchive-ticket')
             ->see('The ticket has been successfully unarchived')
             ->visit($user->company_slug . '/tickets')
             ->see($ticketName)

             // Logout
             ->click('Logout')
             ->seePageIs('auth/login')
             ;

        // Remove user from database
        $user->delete();
    }

}
