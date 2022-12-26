<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Customer\Model\CustomerFactory;

/**
 * Class Social Account
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccount extends \Magento\Framework\Model\AbstractModel
{

    // /**
    //  *
    //  * @var CustomerFactory
    //  */
    // private $_customerFactory;

    /**
     * Initialize address model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Customer\Model\ResourceModel\SocialAccount::class);
    }

    // /**
    //  * Specify address customer
    //  *
    //  * @param Customer $customer
    //  * @return $this
    //  */
    // public function getCustomer(Customer $customer)
    // {
    //     $this->_createCustomerInstance()->load($this->getId()) = $customer;
    //     $this->setCustomerId($customer->getId());
    //     return $this;
    // }

    // /**
    //  * Create Address from Factory
    //  *
    //  * @return Address
    //  */
    // protected function _createCustomerInstance()
    // {
    //     return $this->_customerFactory->create();
    // }

}
