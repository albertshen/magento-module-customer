<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Math\RandomFactory;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Customer\Model\AuthenticationInterface;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Customer\Model\CustomerFactory;
use AlbertMage\Customer\Api\SocialAccountRepositoryInterface;
use AlbertMage\Customer\Api\CustomerTokenServiceInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterface;
use AlbertMage\Customer\Api\Data\CustomerTokenInterfaceFactory;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CustomerTokenService implements CustomerTokenServiceInterface
{
    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var RandomFactory
     */
    private $randomFactory;

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
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var SocialAccountRepositoryInterface
     */
    private $socialAccountRepository;

    /**
     * @var CustomerTokenInterfaceFactory
     */
    private $customerTokenInterfaceFactory;

    /**
     * Initialize service
     *
     * @param ManagerInterface $eventManager
     * @param RandomFactory $randomFactory
     * @param TokenModelFactory $tokenModelFactory
     * @param AuthenticationInterface authentication
     * @param CustomerFactory $customerFactory
     * @param SocialAccountRepositoryInterface $socialAccountRepository
     * @param CustomerTokenInterfaceFactory $customerTokenInterfaceFactory
     */
    public function __construct(
        ManagerInterface $eventManager,
        RandomFactory $randomFactory,
        TokenModelFactory $tokenModelFactory,
        AuthenticationInterface $authentication,
        CustomerFactory $customerFactory,
        SocialAccountRepositoryInterface $socialAccountRepository,
        CustomerTokenInterfaceFactory $customerTokenInterfaceFactory
    ) {
        $this->eventManager = $eventManager;
        $this->randomFactory = $randomFactory;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->authentication = $authentication;
        $this->customerFactory = $customerFactory;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->customerTokenInterfaceFactory = $customerTokenInterfaceFactory;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken(SocialAccountInterface $socialUser)
    {
        try {
            return $this->doCreateCustomerAccessToken($socialUser);
        } catch (UserLockedException $e) {
            throw new UserLockedException(__('The account is locked.'), null, 4004);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }

    }

    /**
     * Create customer AccessToken for miniprogram
     *
     * @return \AlbertMage\Customer\Api\Data\CustomerTokenInterface
     */
    private function doCreateCustomerAccessToken(SocialAccountInterface $socialUser)
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

            return $this->customerTokenInterfaceFactory->create()
                        ->setSocialHash(
                            $socialAccount->getUniqueHash()
                        );
        }

        //create a new social account without binding
        $socialAccount = $this->createSocialAccount($socialUser);

        return $this->customerTokenInterfaceFactory->create()
                    ->setSocialHash(
                        $socialAccount->getUniqueHash()
                    );
    }

    /**
     * Create social account
     * 
     * @param SocialAccountInterface $socialAccount
     * @return SocialAccountInterface
     */
    private function createSocialAccount(SocialAccountInterface $socialAccount)
    {
        $mathRandom = $this->randomFactory->create();
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
        return $this->customerTokenInterfaceFactory->create()
                    ->setToken(
                        $this->tokenModelFactory->create()
                            ->createCustomerToken($customer->getId())
                            ->getToken()
                    );
        
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
