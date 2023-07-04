<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

use AlbertMage\Customer\Api\Data\SocialAccountInterface;

/**
 * Interface CustomerTokenServiceInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface AddressManagementInterface
{

    /**
     * Get primary shipping addresses
     * 
     * @param int $customerId
     * @return \AlbertMage\Customer\Api\Data\AddressInterface|null
     */
    public function getPrimaryShippingAddress($customerId);

    /**
     * Get customer addresses
     * 
     * @param int $customerId
     * @return \AlbertMage\Customer\Api\Data\AddressInterface[]
     */
    public function getCustomerAddresses($customerId);

    /**
     * Save customer address
     * 
     * @param int $customerId
     * @param \AlbertMage\Customer\Api\Data\AddressInterface $address
     * @return \AlbertMage\Customer\Api\Data\AddressInterface
     */
    public function saveCustomerAddress($customerId, \AlbertMage\Customer\Api\Data\AddressInterface $address);

    /**
     * Remove customer address
     * 
     * @param int $customerId
     * @param int $addressId
     * @return bool
     */
    public function removeCustomerAddress($customerId, $addressId);
}