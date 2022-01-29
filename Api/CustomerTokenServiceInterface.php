<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface CustomerTokenServiceInterface
 * @api
 * @since 101.0.0
 */
interface CustomerTokenServiceInterface
{
    /**
     * Create customer AccessToken for miniprogram
     * 
     * @return array
     */
    public function createCustomerAccessToken();

}
