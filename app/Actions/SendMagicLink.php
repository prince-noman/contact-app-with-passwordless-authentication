<?php

namespace App\Actions;

use App\Mail\MagicLoginLink;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SendMagicLink
{
    use AsAction;


    public function rules(){
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }

    public function handle(string $email)
    {
       Mail::to($email)->send(new MagicLoginLink($email));
    }

    public function asController(ActionRequest $request)
    {
        $this->handle($request->input('email'));
        return back()->with('success', 'We have sent you a login link. Please check your email.');
    }
}