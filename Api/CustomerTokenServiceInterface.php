<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

use AlbertMage\Customer\Api\Data\SocialAccountInterface;

/**
 * Interface CustomerTokenServiceInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CustomerTokenServiceInterface
{
    /**
     * Create customer AccessToken for miniprogram
     * 
     * @return \AlbertMage\Customer\Api\Data\CustomerTokenInterface
     */
    public function createCustomerAccessToken(SocialAccountInterface $socialUser);

}
