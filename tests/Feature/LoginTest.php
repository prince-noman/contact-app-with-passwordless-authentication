<?php

use App\Models\User;
use App\Mail\MagicLoginLink;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


// it('ensure the email address exists', function () {
//     $this->post('auth/login', ['email' => 'not_existing_email'])
//          ->assertSessionHasErrors(['email']);
//  });

// it('ensure the email address is valid', function () {
//    $this->post('auth/login', ['email' => 'invalid'])
//         ->assertSessionHasErrors(['email']);
// });


it('ensure the email address exists')
    ->post('auth/login', ['email' => 'not_existing_email'])
    ->assertSessionHasErrors(['email']);


it('ensure the email address is valid')
    ->post('auth/login', ['email' => 'invalid'])
    ->assertSessionHasErrors(['email']);



    it('sends a magic link email', function () {
        Mail::fake();
    
        $user = User::factory()->create(['email' => 'prince@gmail.com']);
    
        $this->post('/auth/login', ['email' => $user->email])
            ->assertSessionHas('success');
    
        Mail::assertSent(MagicLoginLink::class, function (Mailable $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    });