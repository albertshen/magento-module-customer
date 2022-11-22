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
class SocialUserManager implements \AlbertMage\Customer\Api\SocialUserManagerInterface
{

    /**
     * @var SocialUserManagerInterface
     */
    private $socialUserManager;

    /**
     * Initialize service
     *
     * @param Request $request
     * @param SocialUserInterface[]
     */
    public function __construct(
        Request $request,
        array $providers
    ) {
        $type = $request->getParam('type');
        if (isset($providers[$type])) {
            $provider = ObjectManager::getInstance()->get($providers[$type]);
            if (!$provider instanceof \AlbertMage\Customer\Api\SocialUserManagerInterface) {
                throw new \InvalidArgumentException(
                    __('provider should be an instance of SocialUserManagerInterface.')
                );
            }
            $this->socialUserManager = $provider;
        } else {
            $this->socialUserManager = ObjectManager::getInstance()->get($providers['default']);
        }
    }

    /**
     * @inheritdoc
     */
    public function getSocialUser()
    {
        return $this->socialUserManager->getSocialUser();
    }

}
