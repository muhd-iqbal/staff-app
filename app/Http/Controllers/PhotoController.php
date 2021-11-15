<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function create()
    {
        return view('profile.photo', [
            'user' => User::find(auth()->id())
        ]);
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'photo' => 'required|image'
        ]);

        if (isset($attributes['photo'])) {
            $attributes['photo'] = request()->file('photo')->store('photo');
        }

        $user->update($attributes);

        return back()->with('success', 'Foto berjaya diubah!');
    }
}
