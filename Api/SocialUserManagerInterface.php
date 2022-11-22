<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface SocialUserManagerInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
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
