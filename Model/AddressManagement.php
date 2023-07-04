<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerFactory;
use AlbertMage\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\AddressFactory as MageAddressFactory;
use Magento\Directory\Model\RegionFactory;
use AlbertMage\Directory\Model\CityFactory;
use AlbertMage\Directory\Model\DistrictFactory;


/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class AddressManagement implements \AlbertMage\Customer\Api\AddressManagementInterface
{

    /**
     * @var AddressInterfaceFactory
     */
    protected $addressFactory;

    /**
     * @var MageAddressFactory
     */
    protected $mageAddressFactory;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * @var CityFactory
     */
    protected $cityFactory;

    /**
     * @var DistrictFactory
     */
    protected $districtFactory;

    /**
     * Initialize service
     *
     * @param AddressInterfaceFactory $addressFactory
     * @param MageAddressFactory $mageAddressFactory
     * @param CustomerFactory $customerFactory
     * @param RegionFactory $regionFactory
     * @param CityFactory $cityFactory
     * @param DistrictFactory $districtFactory
     */
    public function __construct(
        AddressInterfaceFactory $addressFactory,
        MageAddressFactory $mageAddressFactory,
        CustomerFactory $customerFactory,
        RegionFactory $regionFactory,
        CityFactory $cityFactory,
        DistrictFactory $districtFactory
    ) {
        $this->addressFactory = $addressFactory;
        $this->mageAddressFactory = $mageAddressFactory;
        $this->customerFactory = $customerFactory;
        $this->regionFactory = $regionFactory;
        $this->cityFactory = $cityFactory;
        $this->districtFactory = $districtFactory;
    }

    /**
     * @inheritDoc
     */
    public function getPrimaryShippingAddress($customerId)
    {
        $customer = $this->customerFactory->create()->load($customerId);

        $address = $customer->getPrimaryShippingAddress();
        if($address) {
            return $this->createAddress($address, true);
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getCustomerAddresses($customerId)
    {
        $customer = $this->customerFactory->create()->load($customerId);

        $addresses = [];
        foreach ($customer->getAddressesCollection() as $item) {
            if ($customer->getDefaultShipping() == $item->getId()) {
                $defaultItem = $this->createAddress($item, true);
            } else {
                $addresses[] = $this->createAddress($item, false);
            }
        }
        if (isset($defaultItem)) {
            array_unshift($addresses, $defaultItem);
        }
        return $addresses;
    }

    /**
     * @inheritDoc
     */
    public function saveCustomerAddress($customerId, \AlbertMage\Customer\Api\Data\AddressInterface $address)
    {
        $customer = $this->customerFactory->create()->load($customerId);

        if ($address->getId()) {
            foreach ($customer->getAddressesCollection() as $item) {
                if ($item->getId() == $address->getId()) {
                    $customerAddress = $item;
                    break;
                }
            }
        } else {
            $customerAddress = $this->mageAddressFactory->create();
        }

        $customerAddress->setCountryId('CN');
        $customerAddress->setRegion($address->getRegion());
        $region = $this->regionFactory->create()->loadByName($address->getRegion(), 'CN');
        if ($regionId = $region->getId()) {
            $customerAddress->setRegionId($regionId);
        }
        $customerAddress->setCity($address->getCity());
        $city = $this->cityFactory->create()->loadByName($address->getCity(), $regionId);
        if ($cityId = $city->getId()) {
            $customerAddress->setCityId($cityId);
        }
        $customerAddress->setDistrict($address->getDistrict());
        $district = $this->districtFactory->create()->loadByName($address->getDistrict(), $cityId);
        if ($districtId = $district->getId()) {
            $customerAddress->setDistrictId($districtId);
        }
        $customerAddress->setStreet($address->getStreet());
        $customerAddress->setPostcode($address->getPostcode());
        $customerAddress->setFirstname($address->getFirstname());
        $customerAddress->setLastname($address->getLastname());
        $customerAddress->setEmail($customer->getEmail());
        $customerAddress->setTelephone($address->getTelephone());

        if (!$address->getId()) {
            $customer->addAddress($customerAddress);
        }

        $customer->save();

        if ($address->getIsDefaultShipping()) {

            $customer->setDefaultBilling($customerAddress->getId());
            $customer->setDefaultShipping($customerAddress->getId());

            $customer->save();
        }

        $address = $this->createAddress($customerAddress, $customer->setDefaultShipping() == $customerAddress->getId());


        return $address;
    }

    /**
     * @inheritDoc
     */
    public function removeCustomerAddress($customerId, $addressId) {

        $customer = $this->customerFactory->create()->load($customerId);

        if ($addressId) {
            foreach ($customer->getAddressesCollection() as $item) {
                if ($item->getId() == $addressId) {
                    $item->delete();
                    $customer->save();
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Create address
     * 
     * @param int $customerId
     * @param \Magento\Customer\Model\Address $customerAddress
     * @return \AlbertMage\Customer\Api\Data\AddressInterface
     */
    private function createAddress(\Magento\Customer\Model\Address $customerAddress, $isDefaultShipping = false) {
        $address = $this->addressFactory->create();
        $address->setId($customerAddress->getId());
        $address->setCountryId('CN');
        $address->setRegion($customerAddress->getRegion());
        $address->setRegionId($customerAddress->getRegionId());
        $address->setCity($customerAddress->getCity());
        $address->setCityId($customerAddress->getCityId());
        $address->setDistrict($customerAddress->getDistrict());
        $address->setDistrictId($customerAddress->getDistrictId());
        $address->setStreet($customerAddress->getStreet());
        $address->setPostcode($customerAddress->getPostcode());
        $address->setFirstname($customerAddress->getFirstname());
        $address->setLastname($customerAddress->getLastname());
        $address->setTelephone($customerAddress->getTelephone());
        $address->setIsDefaultShipping($isDefaultShipping);
        return $address;
    }

}
