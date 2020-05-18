<?php

namespace App\Platform\Users\Controllers;

use App\Platform\Users\Requests\ProfileUpdateRequest;
use Domain\Users\Actions\DeleteUserAction;
use Domain\Users\Actions\UpdateUserAction;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController
{
    /**
     * Display the specified resource.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        /** @var \Domain\Users\Models\User */
        $user = Auth::user();

        return Inertia::render('ProfileShowPage', [
            'profile' => fn () => [
                'name' => $user->name,
                'first_surname' => $user->first_surname,
                'second_surname' => $user->second_surname,
                'email' => $user->email,
                'extra_attributes' => $user->extra_attributes,
                'avatar' => $user->avatar,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return Inertia::render('ProfileEditPage', [
            'profile' => fn () => [
                'name' => $user->name,
                'first_surname' => $user->first_surname,
                'second_surname' => $user->second_surname,
                'email' => $user->email,
                'extra_attributes' => $user->extra_attributes,
                'avatar' => $user->avatar,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Domain\Users\Actions\UpdateUserAction  $updateUserAction
     * @param  \App\Platform\Users\Requests\ProfileUpdateRequest  $profileUpdateRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateUserAction $updateUserAction,
        ProfileUpdateRequest $profileUpdateRequest
    ) {
        $updateUserAction->execute(
            Auth::user(),
            UserData::fromProfileUpdateRequest($profileUpdateRequest)
        );

        flash([
            'status' => __('status.profile.updated'),
        ]);

        return Redirect::route('profile.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Domain\Users\Actions\DeleteUserAction  $deleteUserAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteUserAction $deleteUserAction)
    {
        $deleteUserAction->execute(Auth::user());

        flash([
            'status' => __('status.profile.destroyed'),
        ]);

        return Redirect::route('home');
    }
}
