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
use AlbertMage\Customer\Api\WeChat\WeChatUserInfoInterface;
use AlbertMage\Customer\Api\Data\SocialInterface;

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
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $_request;

    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AccountManagement $accountManagement
     * @param AuthenticationInterface authentication
     * @param SocialRepositoryInterface $socialRepository
     * @param Request $request
     * @param ManagerInterface $eventManager
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

        $weChatUser = ObjectManager::getInstance()->create(WeChatUserInfoInterface::class);
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

            if ($socialAccount->getOpenId() === $weChatUser->getOpenId()) {
                return $this->getCustomerToken($socialAccount->getCustomer());
            } 

            if ($socialCollection = $this->socialRepository->getByNotBoundUionId($weChatUser->getUnionId())) {
                foreach ($socialCollection as $socialAccount) {
                    $socialAccount->setCustomerId($socialAccount->getCustomer()->getId());
                    $this->socialRepository->save($socialAccount);
                }
            } else {
                //create and bind a new social account
                $this->createSocialAccount($weChatUser, $socialAccount->getCustomer()->getId());
            }
        }
        
        if ($socialAccount = $this->socialRepository->getByOpenId($weChatUser->getOpenId())) {

            if ($customer = $socialAccount->getCustomer()) {
                return $this->getCustomerToken($socialAccount->getCustomer());
            }
            return ['uniqueHash' => $socialAccount->getUniqueHash()];
        }

        //create a new social account without binding
        $socialAccount = $this->createSocialAccount($weChatUser);

        return ['uniqueHash' => $socialAccount->getUniqueHash()];

    }

    /**
     * Create social account
     * 
     * @param WeChatUserInfoInterface $weChatUser
     * @param string $customerId
     * @return SocialInterface
     */
    private function createSocialAccount(WeChatUserInfoInterface $weChatUser, $customerId = null)
    {
        $socialAccount = ObjectManager::getInstance()->create(SocialInterface::class);
        $mathRadom = ObjectManager::getInstance()->create(\Magento\Framework\Math\Radom::class);
        $socialAccount->setUniqueHash($mathRadom->getUniqueHash());
        $socialAccount->setOpenId($weChatUser->getOpenId());
        $socialAccount->setUnionId($weChatUser->getUnionId());
        if ($customerId) {
            $socialAccount->setCustomerId($customerId);
        }
        $socialAccount->setApplication($weChatUser->getApplication());
        $socialAccount->setPlatform($weChatUser->getPlatform());
        $this->socialRepository->save($socialAccount);
        return $socialAccount;
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
