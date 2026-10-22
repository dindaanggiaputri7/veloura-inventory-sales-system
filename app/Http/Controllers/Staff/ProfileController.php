<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        return view('staff.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        if ($validated['email'] !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->fill($validated)->save();

        return redirect()
            ->route('staff.profile')
            ->with('status', 'profile-updated');
    }
}
