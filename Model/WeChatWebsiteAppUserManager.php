<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Webapi\Rest\Request;
use AlbertMage\Customer\Api\SocialUserInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Interface SocialUserManagerInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class WeChatWebsiteAppUserManager implements \AlbertMage\Customer\Api\SocialUserManagerInterface
{

    const APPLICATION = 'WebsiteApp';

    const PLATFORM = 'WeChat';

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $_request;

    /**
     * @var SocialUserInterface
     */
    protected $socialUser;

    /**
     * Initialize service
     *
     * @param Request $request
     * @param SocialUserInterface
     */
    public function __construct(
        SocialUserInterface $socialUser,
        Request $request
    ) {
        $this->_request = $request;

        $this->socialUser = $socialUser;
        $this->socialUser->setApplication(static::APPLICATION);
        $this->socialUser->setPlatform(static::PLATFORM);
    }

    /**
     * @inheritdoc
     */
    public function getSocialUser()
    {
        $code = $this->_request->getParam('code');
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }
        $openId = 'ddsfdddsaddf';
        $unionId = 'uuasfddfsssdaffsadsfdsadasdfffsddsaf';
        $this->socialUser->setOpenId($openId);
        $this->socialUser->setUnionId($unionId);
        //do somethings
        return $this->socialUser;
    }

}
