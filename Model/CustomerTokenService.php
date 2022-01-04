<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use AlbertMage\Customer\Api\SocialUserInterface;
use AlbertMage\Customer\Api\Data\SocialInterface;
use AlbertMage\Customer\Api\SocialUserManagerInterface;

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
     * @var SocialUserManagerInterface
     */
    private $socialUserManager;

    /**
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;


    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AuthenticationInterface authentication
     * @param SocialRepositoryInterface $socialRepository
     * @param ManagerInterface $eventManager
     * @param SocialUserInterface[]
     */
    public function __construct(
        TokenModelFactory $tokenModelFactory,
        AuthenticationInterface $authentication,
        SocialRepositoryInterface $socialRepository,
        ManagerInterface $eventManager,
        SocialUserManagerInterface $socialUserManager
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->authentication = $authentication;
        $this->socialRepository = $socialRepository;
        $this->eventManager = $eventManager;
        $this->socialUserManager = $socialUserManager;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken()
    {

        try {
            $socialUser = $this->socialUserManager->getSocialUser();
            return $this->doCreateCustomerAccessToken($socialUser);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        } catch (UserLockedException $e) {
            throw new UserLockedException(__('The account is locked.'));
        }

    }

    /**
     * Create customer AccessToken for miniprogram
     *
     * @return array
     */
    private function doCreateCustomerAccessToken($socialUser)
    {

        // Login by UnionId
        if ($socialUser->getUnionId() && $socialAccount = $this->socialRepository->getByBoundUionId($socialUser->getUnionId())) {

            if ($socialAccount->getOpenId() === $socialUser->getOpenId()) {
                return $this->getCustomerToken($socialAccount->getCustomer());
            } 

            if ($socialCollection = $this->socialRepository->getByNotBoundUionId($socialUser->getUnionId())) {
                foreach ($socialCollection as $account) {
                    $account->setCustomerId($socialAccount->getCustomer()->getId());
                    $this->socialRepository->save($account);
                }
            } 

            if (!$this->socialRepository->getByOpenId($socialUser->getOpenId())) {
                //create and bind a new social account
                $this->createSocialAccount($socialUser, $socialAccount->getCustomer()->getId());
            }

        }
        
        //Login by openId
        if ($socialAccount = $this->socialRepository->getByOpenId($socialUser->getOpenId())) {

            if ($customer = $socialAccount->getCustomer()) {
                return $this->getCustomerToken($socialAccount->getCustomer());
            }
            return ['uniqueHash' => $socialAccount->getUniqueHash()];
        }

        //create a new social account without binding
        $socialAccount = $this->createSocialAccount($socialUser);

        return ['uniqueHash' => $socialAccount->getUniqueHash()];

    }

    /**
     * Create social account
     * 
     * @param SocialUserInterface $socialUser
     * @param string $customerId
     * @return SocialInterface
     */
    private function createSocialAccount(SocialUserInterface $socialUser, $customerId = null)
    {
        $socialAccount = ObjectManager::getInstance()->create(SocialInterface::class);
        $mathRandom = ObjectManager::getInstance()->create(\Magento\Framework\Math\Random::class);
        $socialAccount->setUniqueHash($mathRandom->getUniqueHash());
        $socialAccount->setOpenId($socialUser->getOpenId());
        $socialAccount->setUnionId($socialUser->getUnionId());
        if ($customerId) {
            $socialAccount->setCustomerId($customerId);
        }
        $socialAccount->setApplication($socialUser->getApplication());
        $socialAccount->setPlatform($socialUser->getPlatform());
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
