<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Http\Services\UserService;
use Illuminate\Http\RedirectResponse;
use \Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class AuthZohoController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return RedirectResponse|SymfonyRedirectResponse
     */
    public function redirect(): SymfonyRedirectResponse|RedirectResponse
    {
        return Socialite::driver('zoho')
            ->scopes(['ZohoCRM.modules.ALL', 'ZohoCRM.settings.ALL'])
            ->with(['access_type' => 'offline'])
            ->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('zoho')->user();

        $zohoUser = [
            "firstName" => $user->user['First_Name'],
            "lastName" => $user->user['Last_Name'],
            "email" => $user->user['Email'],
            "refresh_token" => $user->refreshToken
        ];

        if (!isset($zohoUser)) {
            throw new BadRequestException('User not fount');
        }

        $auth = $this->userService->createUser($zohoUser);

        return redirect()->route('zohoForm')->with('token', $auth['access_token']);
    }
}
