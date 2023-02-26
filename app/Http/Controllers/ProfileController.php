<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the teachers's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->teachers() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the teachers's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->teachers()->fill($request->validated());

        if ($request->teachers()->isDirty('email')) {
            $request->teachers()->email_verified_at = null;
        }

        $request->teachers()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the teachers's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $teachers = $request->teachers();

        Auth::logout();

        $teachers->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
