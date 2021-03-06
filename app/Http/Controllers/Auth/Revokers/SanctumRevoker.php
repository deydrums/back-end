<?php

namespace App\Http\Controllers\Auth\Revokers;


use App\Http\Controllers\Auth\Interfaces\Revoker;

class SanctumRevoker implements Revoker
{

    /**
     * @var User
     */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * It revokes by updating only the token in database, that is given when user do a login.
     * @return
     */
    public function revokeOnlyCurrentToken()
    {
        return $this->deleteCurrentToken();
    }

    /**
     * It revoke by updating all tokens of the user when user logout, it keeps them on database.
     */
    public function revokeAllTokens()
    {
        return $this->deleteAllTokens();
    }

    /**
     * It deletes the current token in database, the token deleted is the one used by the user use to login.
     * @return
     */
    public function deleteCurrentToken()
    {
        return $this->user->currentAccessToken()->delete();
    }

    /**
     * It deletes all tokens in database used by the user when user logout.
     */
    public function deleteAllTokens()
    {
        $this->user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }
}
