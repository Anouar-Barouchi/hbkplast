<?php

namespace Modules\User\Guards;

use Modules\User\Entities\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelFacade;

class Sentinel implements Guard
{
    /**
     * Determine if the current user is authenticated.
     *
     * @return \Modules\User\Entities\User|bool
     */
    public function check()
    {
        try {
            return SentinelFacade::check();
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return \Modules\User\Entities\User|bool
     */
    public function guest()
    {
        try {
            return SentinelFacade::guest();
        } catch (\Throwable $th) {
            return false;
        }
        
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        try {
            return SentinelFacade::getUser();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($user = SentinelFacade::check()) {
            return $user->id;
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return SentinelFacade::validForCreation($credentials);
    }

    /**
     * Set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param \Modules\User\Entities\User|bool
     */
    public function setUser(Authenticatable $user)
    {
        return SentinelFacade::login($user);
    }

    /**
     * Alias to set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return \Modules\User\Entities\User|bool
     */
    public function login(Authenticatable $user)
    {
        return $this->setUser($user);
    }

    /**
     * Attempt to logging in user.
     *
     * @param array $credentials
     * @param bool $remember
     * @return \Modules\User\Entities\User|bool
     */
    public function attempt(array $credentials, $remember = false)
    {
        return SentinelFacade::authenticate($credentials, $remember);
    }

    /**
     * Logout user.
     *
     * @return bool
     */
    public function logout()
    {
        return SentinelFacade::logout();
    }

    /**
     * Login using user id.
     *
     * @param int $userId
     * @return \Modules\User\Entities\User|bool
     */
    public function loginUsingId($userId)
    {
        $user = User::findOrFail($userId);

        return $this->login($user);
    }


    public function hasUser()
    {
        // TODO: Implement hasUser() method.
    }
}
