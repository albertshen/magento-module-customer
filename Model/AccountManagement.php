<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use AlbertMage\Customer\Api\SocialAccountRepositoryInterface;
use AlbertMage\Customer\Api\Data\CustomerTokenInterfaceFactory;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class AccountManagement implements \AlbertMage\Customer\Api\AccountManagementInterface
{

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerResource
     */
    protected $customerResource;

    /**
     * @var SocialAccountRepositoryInterface
     */
    private $socialAccountRepository;

    /**
     * @var CustomerTokenInterfaceFactory
     */
    private $customerTokenInterfaceFactory;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * Initialize service
     *
     * @param StoreManagerInterface $storeManager
     * @param TokenModelFactory $tokenModelFactory
     * @param CustomerFactory $customerFactory
     * @param CustomerResource $customerResource
     * @param SocialAccountRepositoryInterface $socialAccountRepository
     * @param CustomerTokenInterfaceFactory $customerTokenInterfaceFactory
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        TokenModelFactory $tokenModelFactory,
        CustomerFactory $customerFactory,
        CustomerResource $customerResource,
        SocialAccountRepositoryInterface $socialAccountRepository,
        CustomerTokenInterfaceFactory $customerTokenInterfaceFactory,
        EventManagerInterface $eventManager
    ) {
        $this->storeManager = $storeManager;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->customerTokenInterfaceFactory = $customerTokenInterfaceFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * Get customer account by phone.
     *
     * @param string $phone
     * @return \Magento\Customer\Model\Customer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAccount($phone)
    {
        $customer = $this->customerFactory->create()->getCollection()->addFieldToFilter("phone", array("eq" => $phone))->getFirstItem();

        if($customer->getId()) {
            return $customer;
        }

        return $this->createAccount($phone);

    }

    /**
     * Create customer account.
     *
     * @param string $phone
     * @return \Magento\Customer\Model\Customer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createAccount($phone)
    {
        $store = $this->storeManager->getStore();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId)
            ->setStore($store)
            ->setFirstname($phone)
            ->setLastname($phone)
            ->setEmail($phone.'@phpdigital.com')
            ->setForceConfirmed(true);

        try {
            //save customer
            $customer->setPhone($phone);
            $this->customerResource->save($customer);
            return $customer;
        } catch (AlreadyExistsException $e) {
            throw new AlreadyExistsException(__($e->getMessage()), $e);
        } catch (\Exception $e) {
            throw new \RuntimeException(__($e->getMessage()));
        }
    }

    /**
     * Bind social account.
     *
     * @param int $customerId
     * @param int $socialId
     * @return \AlbertMage\Customer\Api\Data\SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bindSocialAccount($customerId, $socialId)
    {
 
        $socialAccount = $this->socialAccountRepository->getById($socialId);
        if(!$socialAccount->getId()) {
            throw new LocalizedException(__('social hash is not exist'));
        }

        if($socialAccount->getCustomerId()) {
            throw new LocalizedException(__('social hash has been bond'), null, 4002);
        }

        //bind social account
        $socialAccount->setCustomerId($customerId);
        $this->socialAccountRepository->save($socialAccount);

        $this->eventManager->dispatch(
            'social_account_bind_after',
            ['social_account' => $socialAccount]
        );

        return $socialAccount;
    }

}
