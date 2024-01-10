<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'name' => ['required', 'max:255']
        ];
    }

    public function handle(string $email, string $name)
    {
        return User::create([
            'email' => $email,
            'name' => $name
        ]);
    }

    public function asController(ActionRequest $request, SendMagicLink $sendMagicLink){
        // Send data to handle method
        $user = $this->handle($request->input('email'), $request->input('name'));
        // Send Magic Link
        $sendMagicLink->handle($user->email);
        // Return with success
        return back()->with('success', 'Registered. We have sent you a login link. Please check your email.');
    }
}