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

    const TYPE = 'type';
    
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
     * Get token type
     *
     * @return string|null
     */
    public function getType();

    /**
     * Set token type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type);
}
