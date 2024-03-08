<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user()
    {
        $users = User::all();
        $categories= category::all();
        return view('admin', compact('users','categories'));
    }

    public function ban(User $user)
    {
        // Logique pour bannir l'utilisateur
    }


    public function toggleBan(User $user)
    {
        $user->update(['ban' => !$user->ban]);
        return redirect()->back()->with('success', 'User ban status toggled successfully.');
    }

}
