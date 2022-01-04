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
class WeChatWxappUserManager implements \AlbertMage\Customer\Api\SocialUserManagerInterface
{

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $_request;

    /**
     * Initialize service
     *
     * @param Request $request
     * @param SocialUserInterface[]
     */
    public function __construct(
        Request $request
    ) {
        $this->_request = $request;
    }

    /**
     * @inheritdoc
     */
    public function getSocialUser()
    {
        $code = $this->_request->getParam('code');
        $openId = 'ddsfsaddf';
        $unionId = 'uuasfdfssdaffsadsfdsadasdfffsddsaf';

        $socialUser = ObjectManager::getInstance()->create(SocialUserInterface::class);
        $socialUser->setApplication('miniprogram');
        $socialUser->setPlatform('WeChat');
        $socialUser->setOpenId($openId);
        $socialUser->setUnionId($unionId);
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }
        //do somethings
        return $socialUser;
    }

}
