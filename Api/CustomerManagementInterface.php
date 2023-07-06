<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

use AlbertMage\Customer\Api\Data\SocialAccountInterface;

/**
 * Interface CustomerManagementInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface CustomerManagementInterface
{

    /**
     * Get customer
     * 
     * @param int $customerId
     * @return \AlbertMage\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomer($customerId);

    /**
     * Save customer
     * 
     * @param int $customerId
     * @param \AlbertMage\Customer\Api\Data\CustomerInterface $customer
     * @return bool
     */
    public function saveCustomer($customerId, \AlbertMage\Customer\Api\Data\CustomerInterface $customer);

}