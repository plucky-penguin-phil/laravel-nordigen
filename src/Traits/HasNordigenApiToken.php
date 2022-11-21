<?php

namespace PluckyPenguin\LaravelNordigen\Traits;

use Carbon\Carbon;
use PluckyPenguin\LaravelNordigen\Facades\NordigenClient;

/**
 * @property string nordigen_access_token
 * @property string nordigen_refresh_token
 * @property Carbon nordigen_access_expires
 * @property Carbon nordigen_refresh_expires
 */
trait HasNordigenApiToken
{
    public function initializeHasNordigenApiToken()
    {
        $this->casts['nordigen_access_expires']  = 'datetime';
        $this->casts['nordigen_refresh_expires'] = 'datetime';

        $this->dates[] = 'nordigen_access_expires';
        $this->dates[] = 'nordigen_refresh_expires';
    }

    /**
     * Get the user's access token for the Nordigen API.
     * If one has not been created, or it has expired, a new
     * token will be requested.
     *
     * @return string
     */
    public function getNordigenAccessToken(): string
    {
        if (empty($this->nordigen_access_token) || $this->hasNordigenAccessTokenExpired()) {
            if ($this->hasNordigenRefreshTokenExpired()) {
                $this->createAccessToken();
            } else {
                $this->refreshAccessToken();
            }
        }

        return $this->nordigen_access_token;
    }

    /**
     * Check if the user's nordigen access token has expired.
     *
     * @return bool
     */
    public function hasNordigenAccessTokenExpired(): bool
    {
        return Carbon::now()->isAfter($this->nordigen_access_expires);
    }

    /**
     * Check if the user's nordigen refresh token has expired.
     *
     * @return bool
     */
    public function hasNordigenRefreshTokenExpired(): bool
    {
        return Carbon::now()->isAfter($this->nordigen_refresh_expires);
    }

    /**
     * Create a new access token.
     *
     * @return void
     */
    public function createAccessToken()
    {
        $accessToken = NordigenClient::createAccessToken();

        $this->nordigen_access_token    = $accessToken['access'];
        $this->nordigen_access_expires  = Carbon::now()->addSeconds($accessToken['access_expires']);
        $this->nordigen_refresh_token   = $accessToken['refresh'];
        $this->nordigen_refresh_expires = Carbon::now()->addSeconds($accessToken['refresh_expires']);

        $this->save();
    }

    /**
     * Refresh the user's nordigen API token.
     *
     * @return void
     */
    public function refreshAccessToken()
    {
        $token                         = NordigenClient::refreshAccessToken($this->nordigen_refresh_token);
        $this->nordigen_access_token   = $token['access'];
        $this->nordigen_access_expires = Carbon::now()->addSeconds($token['access_expires']);
        $this->save();
    }

    /**
     * Sign the user into the Nordigen API.
     *
     * @return void
     */
    public function authNordigen(): void
    {
        if (!empty($this->nordigen_access_token) && Carbon::now()->isBefore($this->nordigen_access_expires)) {
            NordigenClient::setAccessToken($this->nordigen_access_token);

            return;
        }

        if ($this->hasNordigenAccessTokenExpired()) {
            if ($this->hasNordigenRefreshTokenExpired()) {
                $this->createAccessToken();
            } else {
                $this->refreshAccessToken();
            }

            return;
        }

        $this->createAccessToken();
    }
}
