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
        $user = Auth::user();

        if (is_null($user)) {
            abort(403);
        }

        $updateUserAvatarAction->execute(
            $user,
            UserData::fromUpdateProfileAvatarRequest($updateProfileAvatarRequest)
        );

        flash()->success(is_string($flash = __('profile.flash.avatar_updated')) ? $flash : '');

        return Redirect::back();
    }
}
