<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use AlbertMage\Customer\Api\Data\CustomerInterfaceFactory;


/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CustomerManagement implements \AlbertMage\Customer\Api\CustomerManagementInterface
{

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerResource
     */
    protected $customerResource;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerInterfaceFactory;

    /**
     * Initialize service
     *
     * @param CustomerFactory $customerFactory
     * @param CustomerResource $customerResource
     * @param CustomerInterfaceFactory $customerInterfaceFactory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        CustomerResource $customerResource,
        CustomerInterfaceFactory $customerInterfaceFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
    }

    /**
     * Get customer
     * 
     * @param int $customerId
     * @return \AlbertMage\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer($customerId)
    {
        $customer = $this->customerFactory->create()->load($customerId);
        $newCustomer = $this->customerInterfaceFactory->create();
        $newCustomer->setPicture($customer->getPicture());
        $newCustomer->setNickname($customer->getNickname());
        $newCustomer->setPhone($customer->getPhone());
        if ('奇植' != $customer->getFirstname()) {
            $newCustomer->setFirstname($customer->getFirstname());
        }
        if ('怪' != $customer->getLastname()) {
            $newCustomer->setLastname($customer->getLastname());
        }
        $newCustomer->setGender($customer->getGender());
        if (!strpos($customer->getEmail(), '@phpdigital.com')) {
            $newCustomer->setEmail($customer->getEmail());
        }
        $newCustomer->setBirthday($customer->getDob());
        $newCustomer->setProvince($customer->getProvince());
        $newCustomer->setCity($customer->getCity());
        $newCustomer->setDistrict($customer->getDistrict());
        return $newCustomer;
    }

    /**
     * Save customer
     * 
     * @param int $customerId
     * @param \AlbertMage\Customer\Api\Data\CustomerInterface $customer
     * @return bool
     */
    public function saveCustomer($customerId, \AlbertMage\Customer\Api\Data\CustomerInterface $customer)
    {
        try {

            $mageCustomer = $this->customerFactory->create()->load($customerId);

            if ($nickname = $customer->getNickname()) {
                $mageCustomer->setNickname($nickname);
            }

            if ($picture = $customer->getPicture()) {
                $mageCustomer->setPicture($picture);
            }

            if ($customer->getFirstname() && '奇植' == $mageCustomer->getFirstname()) {
                $mageCustomer->setFirstname($customer->getFirstname());
            }
            if ($customer->getLastname() && '怪' == $mageCustomer->getLastname()) {
                $mageCustomer->setLastname($customer->getLastname());
            }
            if ($customer->getGender() && !$mageCustomer->getGender()) {
                $mageCustomer->setGender($customer->getGender());
            }
            if ($customer->getEmail()) {
                $mageCustomer->setEmail($customer->getEmail());
            }
            if ($customer->getBirthday() && !$mageCustomer->getDob()) {
                $mageCustomer->setDob($customer->getBirthday());
            }
            if ($province = $customer->getProvince()) {
                $mageCustomer->setProvince($province);
            }
            if ($city = $customer->getCity()) {
                $mageCustomer->setCity($city);
            }
            if ($district = $customer->getDistrict()) {
                $mageCustomer->setDistrict($district);
            }
            $mageCustomer->save();

            return true;

        } catch (AlreadyExistsException $e) {
            throw new AlreadyExistsException(__('A customer with the same email address already exists in an associated website.'), null, 4200);
        }
    }

}
