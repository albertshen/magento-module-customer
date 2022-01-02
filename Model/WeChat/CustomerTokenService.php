<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Customer\Model\WeChat;

use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use AlbertMage\Customer\Api\WeChat\WeChatUserInterface;
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
     * @param AuthenticationInterface authentication
     * @param SocialRepositoryInterface $socialRepository
     * @param Request $request
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        TokenModelFactory $tokenModelFactory,
        AuthenticationInterface $authentication,
        SocialRepositoryInterface $socialRepository,
        Request $request,
        ManagerInterface $eventManager
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->authentication = $authentication;
        $this->socialRepository = $socialRepository;
        $this->_request = $request;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken()
    {

        $code = $this->_request->getParam('code');
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }

        $weChatUser = ObjectManager::getInstance()->create(WeChatUserInterface::class);
        $weChatUser->setApplication('web');
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
                foreach ($socialCollection as $account) {
                    $account->setCustomerId($socialAccount->getCustomer()->getId());
                    $this->socialRepository->save($account);
                }
            } 

            if (!$this->socialRepository->getByOpenId($weChatUser->getOpenId())) {
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
     * @param WeChatUserInterface $weChatUser
     * @param string $customerId
     * @return SocialInterface
     */
    private function createSocialAccount(WeChatUserInterface $weChatUser, $customerId = null)
    {
        $socialAccount = ObjectManager::getInstance()->create(SocialInterface::class);
        $mathRandom = ObjectManager::getInstance()->create(\Magento\Framework\Math\Random::class);
        $socialAccount->setUniqueHash($mathRandom->getUniqueHash());
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
        return ['token' => $this->tokenModelFactory->create()->createCustomerToken($customer->getId())->getToken()];
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
