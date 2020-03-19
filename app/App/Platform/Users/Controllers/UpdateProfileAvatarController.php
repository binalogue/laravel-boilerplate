<?php

namespace App\Platform\Users\Controllers;

use App\Platform\Users\Requests\UpdateProfileAvatarRequest;
use Domain\Users\Actions\UpdateUserAvatarAction;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UpdateProfileAvatarController
{
    /**
     * Update the profile avatar.
     *
     * @param  \App\Platform\Users\Requests\UpdateProfileAvatarRequest  $updateProfileAvatarRequest
     * @param  \Domain\Users\Actions\UpdateUserAvatarAction  $updateUserAvatarAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        UpdateProfileAvatarRequest $updateProfileAvatarRequest,
        UpdateUserAvatarAction $updateUserAvatarAction
    ) {
        $updateUserAvatarAction->execute(
            Auth::user(),
            UserData::fromUpdateProfileAvatarRequest($updateProfileAvatarRequest)
        );

        flash([
            'status' => __('status.profile.avatar_updated'),
        ]);

        return Redirect::back();
    }
}
