<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface SocialUserManagerInterface
 * @api
 * @since 101.0.0
 */
interface SocialUserManagerInterface
{
    /**
     * Get Social User
     *
     * @return SocialUserInterface
     */
    public function getSocialUser();

}
