<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface CustomerInterface
 * @api
 * @since 101.0.0
 */
interface CustomerInterface
{
    /**
     * Customer login by miniprogram
     *
     * @return array
     */
    public function login();

}
