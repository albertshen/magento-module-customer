<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api\Data;

/**
 * Interface CustomerTokenInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CustomerTokenInterface
{
    const TOKEN = 'token';

    const GUEST_TOKEN = 'guest_token';
    
    /**
     * Get Customer token
     *
     * @return string|null
     */
    public function getToken();

    /**
     * Set Customer token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token);

    /**
     * Get guest token
     *
     * @return string|null
     */
    public function getGuestToken();

    /**
     * Set guest token
     *
     * @param string $guestToken
     * @return $this
     */
    public function setGuestToken($guestToken);
}
