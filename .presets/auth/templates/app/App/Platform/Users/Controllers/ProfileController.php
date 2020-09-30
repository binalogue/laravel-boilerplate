<?php

namespace App\Platform\Users\Controllers;

use App\Platform\Users\Requests\ProfileUpdateRequest;
use Domain\Users\Actions\DeleteUserAction;
use Domain\Users\Actions\UpdateUserAction;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

/** @see \Tests\App\Platform\Users\Controllers\ProfileControllerTest */
class ProfileController
{
    public function show(): Response
    {
        /** @var \Domain\Users\Models\User */
        $user = Auth::user();

        return Inertia::render('ProfileShowPage', [
            'profile' => fn () => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'extra_attributes' => $user->extra_attributes,
                'avatar' => $user->avatar,
            ],
        ]);
    }

    public function edit(): Response
    {
        $user = Auth::user();

        if (is_null($user)) {
            abort(403);
        }

        return Inertia::render('ProfileEditPage', [
            'profile' => fn () => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'extra_attributes' => $user->extra_attributes,
                'avatar' => $user->avatar,
            ],
        ]);
    }

    public function update(
        UpdateUserAction $updateUserAction,
        ProfileUpdateRequest $profileUpdateRequest
    ): RedirectResponse {
        $user = Auth::user();

        if (is_null($user)) {
            abort(403);
        }

        $updateUserAction->execute(
            $user,
            UserData::fromProfileUpdateRequest($profileUpdateRequest)
        );

        flash()->success(is_string($flash = __('profile.flash.updated')) ? $flash : '');

        return Redirect::route('profile.show');
    }

    public function destroy(DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $user = Auth::user();

        if (is_null($user)) {
            abort(403);
        }

        $deleteUserAction->execute($user);

        flash()->success(is_string($flash = __('profile.flash.destroyed')) ? $flash : '');

        return Redirect::route('home');
    }
}
