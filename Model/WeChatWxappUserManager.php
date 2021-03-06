<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Webapi\Rest\Request;
use AlbertMage\Customer\Api\SocialUserInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Interface SocialUserManagerInterface
 * @api
 * @since 101.0.0
 */
class WeChatWxappUserManager extends WeChatWebsiteAppUserManager
{

    const APPLICATION = 'Miniprogram';

    const PLATFORM = 'WeChat';

    /**
     * @inheritdoc
     */
    public function getSocialUser()
    {
        $code = $this->_request->getParam('code');
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }

        $openId = 'd4d6-6sfdddsaddf';
        $unionId = 'uuasfd-d6334fsssdaffsadsfdsadasdfffsddsaf';
        $this->socialUser->setOpenId($openId);
        $this->socialUser->setUnionId($unionId);
        //do somethings
        return $this->socialUser;
    }

}
