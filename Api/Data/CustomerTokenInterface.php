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

    const SOCIAL_HASH = 'social_hash';
    
    /**
     * Get Customer token
     *
     * @return string
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
     * Get social account hash
     *
     * @return string
     */
    public function getSocialHash();

    /**
     * Set social account hash
     *
     * @param string $socialHash
     * @return $this
     */
    public function setSocialHash($socialHash);
}
