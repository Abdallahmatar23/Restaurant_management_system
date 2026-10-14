<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->only(['name', 'phone']);

        if ($request->hasFile('profile_picture')) {
            // امسح الصورة القديمة لو كانت مرفوعة (مش الـ default)
            if (str_starts_with($user->profile_picture, 'storage/profiles/')) {
                Storage::disk('public')->delete(Str::after($user->profile_picture, 'storage/'));
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $data['profile_picture'] = 'storage/' . $path;
        }

        $user->update($data);

        return back()->with('status', 'Profile updated successfully.');
    }
}
