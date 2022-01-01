<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Catalog\Model\WeChat;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;

/**
 *
 */
class CustomerTokenService
{

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    /**
     * @var AccountManagement
     */
    private $accountManagement;

    /**
     * @var AuthenticationInterface
     */
    protected $authentication;

    /**
     * @var SocialRepositoryInterface
     */
    private $socialRepository;

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $_request;

    /**
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AccountManagement $accountManagement
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     */
    public function __construct(
        TokenModelFactory $tokenModelFactory,
        AccountManagement $accountManagement,
        AuthenticationInterface $authentication,
        SocialRepositoryInterface $socialRepository,
        Request $request,
        ManagerInterface $eventManager
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->accountManagement = $accountManagement;
        $this->authentication = $authentication;
        $this->_request = $request;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken()
    {

        $code = $this->_request->getParam('code');
        //do something
        
        $weChatUser = ObjectManager::getInstance()->create(\AlbertMage\Customer\Api\WeChat\WeChatUserInfoInterface::class);
        $weChatUser->setApplication('miniprogram');
        $weChatUser->setPlatform('WeChat');
        $weChatUser->setOpenId($openId);
        $weChatUser->setUnionId($unionId);

        try {
            return $this->doCreateCustomerAccessToken($weChatUser);
        } catch (UserLockedException $e) {
            throw new UserLockedException(__('The account is locked.'));
        }

    }

    /**
     * Create customer AccessToken for miniprogram
     *
     * @return array
     */
    private function doCreateCustomerAccessToken($weChatUser)
    {

        if ($weChatUser->getUnionId() && $socialAccount = $this->socialRepository->getByBoundUionId($weChatUser->getUnionId())) {
            if ($socialAccount->getOpenId() !== $weChatUser->getOpenId()) {
                $newSocialAccount = ObjectManager::getInstance()->create(\AlbertMage\Customer\Api\Data\SocialInterface::class);
                $newSocialAccount->setOpenId($weChatUser->getOpenId());
                $newSocialAccount->setCustomerId($socialAccount->getCustomerId());
                $newSocialAccount->setUnionId($weChatUser->getUnionId());
                $newSocialAccount->setApplication($weChatUser->getApplication());
                $newSocialAccount->setPlatform($weChatUser->getPlatform());
                $this->socialRepository->save($socialAccount);
            }
            return $this->getCustomerToken($socialAccount->getCustomer());
        }
        
        if ($socialAccount = $this->socialRepository->getByOpenId($weChatUser->getUnionId())) {

            if ($customer = $socialAccount->getCustomer()) {
                return $this->getCustomerToken($socialAccount->getCustomer());
            }
            return ['uniqueHash' => $socialAccount->getUniqueHash()];
        }

        //create a new social account without binding
        $mathRadom = \Magento\Framework\App\ObjectManager::getInstance()->create(\Magento\Framework\Math\Radom::class);
        $uniqueHash = $mathRadom->getUniqueHash();
        $newSocialAccount = ObjectManager::getInstance()->create(\AlbertMage\Customer\Api\Data\SocialInterface::class);
        $newSocialAccount->setOpenId($weChatUser->getOpenId());
        $newSocialAccount->setUnionId($weChatUser->getUnionId());
        $newSocialAccount->setApplication($weChatUser->getApplication());
        $newSocialAccount->setPlatform($weChatUser->getPlatform());
        $newSocialAccount->setUniqueHash($uniqueHash);
        $this->socialRepository->save($socialAccount);

        return ['uniqueHash' => $uniqueHash];

    }

    /**
     * Get Customer Token
     *
     * @return array
     * @throws UserLockedException
     */
    private function getCustomerToken($customer)
    {
        if ($this->getAuthentication()->isLocked($customer->getId())) {
            throw new UserLockedException(__('The account is locked.'));
        }
        $this->eventManager->dispatch('customer_data_object_login', ['customer' => $customer]);
        $this->eventManager->dispatch('customer_login', ['customer' => $customer]);
        return ['token' => $this->tokenModelFactory->create()->createCustomerToken($customer->getCustomerId())->getToken()];
    }

    /**
     * Get authentication
     *
     * @return AuthenticationInterface
     */
    private function getAuthentication()
    {
        return $this->authentication;
    }

}
