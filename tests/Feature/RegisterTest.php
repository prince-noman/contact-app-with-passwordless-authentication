<?php

use App\Mail\MagicLoginLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('ensures the email address is valid')
    ->post('/auth/register', ['email' => 'nope'])
    ->assertSessionHasErrors(['email']);

it('ensures the name is present')
    ->post('/auth/register', ['email' => 'prince@gmail.com'])
    ->assertSessionHasErrors(['name']);

it('ensures the email adddress does not exist already', function () {
    $user = User::factory()->create(['email' => 'prince@gmail.com']);

    $this->post('/auth/register', ['email' => $user->email, 'name' => 'Prince'])
        ->assertSessionHasErrors(['email']);
});

it('registers a user and sends a magic login link', function () {
    Mail::fake();

    $this->post('/auth/register', ['email' => $email = 'prince@gmail.com', 'name' => 'Prince']);

    $this->assertDatabaseHas(User::class, [
        'email' => $email,
        'name' => 'Prince'
    ]);

    Mail::assertSent(MagicLoginLink::class, fn (Mailable $mail) => $mail->hasTo($email));
});