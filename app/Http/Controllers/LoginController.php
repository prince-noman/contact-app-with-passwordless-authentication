<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    // public function __construct(){
    //     $this->middleware(['signed']);
    // }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        // dd('login', $user);
        auth()->login($user);
        return redirect()->route('home');
    }
}