<?php

namespace App\Platform\Users\Controllers;

use App\Platform\Users\Requests\UpdateProfileAvatarRequest;
use Domain\Users\Actions\UpdateUserAvatarAction;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UpdateProfileAvatarController
{
    public function __invoke(
        UpdateProfileAvatarRequest $updateProfileAvatarRequest,
        UpdateUserAvatarAction $updateUserAvatarAction
    ): RedirectResponse {
        $updateUserAvatarAction->execute(
            Auth::user(),
            UserData::fromUpdateProfileAvatarRequest($updateProfileAvatarRequest)
        );

        flash()->success(__('status.profile.avatar_updated'));

        return Redirect::back();
    }
}
