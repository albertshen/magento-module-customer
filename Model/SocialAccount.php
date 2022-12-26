<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class Social Account
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccount extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Initialize address model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Customer\Model\ResourceModel\SocialAccount::class);
    }

    /**
     * Specify address customer
     *
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        return $this->_createCustomerInstance()->load($this->getCustomerId());
    }

    /**
     * Create Address from Factory
     *
     * @return Address
     */
    protected function _createCustomerInstance()
    {
        return ObjectManager::getInstance()->create(Magento\Customer\Model\Customer::class);
    }

}
