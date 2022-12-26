<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use AlbertMage\Customer\Api\Resource\SocialAccountRepositoryInterface;
use AlbertMage\Customer\Api\Data\CustomerTokenInterfaceFactory;


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
     * Initialize service
     *
     * @param StoreManagerInterface $storeManager
     * @param TokenModelFactory $tokenModelFactory
     * @param CustomerFactory $customerFactory
     * @param CustomerResource $customerResource
     * @param SocialAccountRepositoryInterface $socialAccountRepository
     * @param CustomerTokenInterfaceFactory $customerTokenInterfaceFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        TokenModelFactory $tokenModelFactory,
        CustomerFactory $customerFactory,
        CustomerResource $customerResource,
        SocialAccountRepositoryInterface $socialAccountRepository,
        CustomerTokenInterfaceFactory $customerTokenInterfaceFactory
    ) {
        $this->storeManager = $storeManager;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->customerTokenInterfaceFactory = $customerTokenInterfaceFactory;
    }

    /**
     * @inheritdoc
     */
    public function createAccount($phone, $verifyCode, $socialHash = null)
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

        if($customer->getCollection()->addFieldToFilter("phone", array("eq" => $phone))->getSize()) {
            throw new AlreadyExistsException(__('phone already exist'));
        }
 
        if(!$socialAccount = $this->socialAccountRepository->getByUniqueId($socialHash)) {
            throw new LocalizedException(__('social hash is not exist'));
        }

        try {
            //save customer
            $customer->setPhone($phone);
            $this->customerResource->save($customer);

            //bind social account
            $socialAccount->setCustomerId($customer->getId());
            $this->socialAccountRepository->save($socialAccount);

            return $this->customerTokenInterfaceFactory->create()
                        ->setToken(
                            $this->tokenModelFactory->create()
                                ->createCustomerToken($customer->getId())
                                ->getToken()
                        );
        } catch (AlreadyExistsException $e) {
            throw new AlreadyExistsException(__($e->getMessage()), $e);
        } catch (\Exception $e) {
            throw new \RuntimeException(__($e->getMessage()));
        }
    }

}
