<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ManagerInterface;
use AlbertMage\Customer\Api\SocialAccountRepositoryInterface;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Customer\Model\CustomerFactory;
use AlbertMage\Customer\Api\SocialUserInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterface;
use AlbertMage\Customer\Api\SocialUserManagerInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
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
     * @var SocialAccountRepositoryInterface
     */
    private $socialAccountRepository;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory

    /**
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AuthenticationInterface authentication
     * @param SocialAccountRepositoryInterface $socialAccountRepository
     * @param ManagerInterface $eventManager
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        TokenModelFactory $tokenModelFactory,
        AuthenticationInterface $authentication,
        SocialAccountRepositoryInterface $socialAccountRepository,
        CustomerFactory $customerFactory,
        ManagerInterface $eventManager
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->authentication = $authentication;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->customerFactory = $customerFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken(\AlbertMage\Customer\Model\SocialAccount $socialAccount)
    {

        try {
            return $this->doCreateCustomerAccessToken($socialAccount);
        } catch (UserLockedException $e) {
            throw new UserLockedException(__('The account is locked.'), null, 4004);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
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
        if ($socialUser->getUnionId() && $socialAccount = $this->socialAccountRepository->getOneByBoundUionId($socialUser->getUnionId())) {

            // if ($socialAccount->getOpenId() === $socialUser->getOpenId()) {
            //     return $this->getCustomerToken($socialAccount->getCustomer());
            // } 

            // Bind customer for all those exist social accounts without binding
            if ($socialAccountCollection = $this->socialAccountRepository->getByNotBoundUionId($socialAccount->getUnionId())) {
                foreach ($socialAccountCollection as $account) {
                    $account->setCustomerId($socialAccount->getCustomerId());
                    $this->socialAccountRepository->save($account);
                }
            }

            // Bind customer for current new social account which id base on openid
            if (!$this->socialAccountRepository->getOneByOpenId($socialUser->getOpenId())) {
                //create and bind a new social account
                $socialUser->setCustomerId($socialAccount->getCustomerId());
                $this->createSocialAccount($socialUser);
            }

            // Generate customer token
            return $this->getCustomerToken($socialAccount->getCustomerId());

        }
        
        //Login by openId
        if ($socialAccount = $this->socialAccountRepository->getOneByOpenId($socialUser->getOpenId())) {

            if ($customerId = $socialAccount->getCustomerId()) {
                return $this->getCustomerToken($customerId);
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
     * @param SocialAccountInterface $socialAccount
     * @param string $customerId
     * @return SocialAccountInterface
     */
    private function createSocialAccount(SocialAccountInterface $socialAccount)
    {
        $socialAccount = ObjectManager::getInstance()->create(SocialAccountInterface::class);
        $mathRandom = ObjectManager::getInstance()->create(\Magento\Framework\Math\Random::class);
        $socialAccount->setUniqueHash($mathRandom->getUniqueHash());
        $this->socialAccountRepository->save($socialAccount);
        return $socialAccount;
    }

    /**
     * Get Customer Token
     *
     * @param string $customerId
     * @return array
     * @throws UserLockedException
     */
    private function getCustomerToken($customerId)
    {
        $customer = $this->customerFactory->create()->load($customerId);

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
