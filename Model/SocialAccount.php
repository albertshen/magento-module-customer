<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use AlbertMage\Customer\Api\Data\SocialAccountInterface;

/**
 * Class Social Account
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccount extends AbstractExtensibleModel implements SocialAccountInterface
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
     * @inheritDoc
     */
    public function getId()
    {
        return parent::getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($entityId)
    {
        return $this->setData(self::ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        return parent::getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Specify address customer
     *
     * @param Customer $customer
     * @return $this
     */
    public function setCustomer(Customer $customer)
    {
        $this->_customer = $customer;
        $this->setCustomerId($customer->getId());
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOpenId()
    {
        return parent::getData(self::OPENID);
    }

    /**
     * @inheritDoc
     */
    public function setOpenId($openId)
    {
        return $this->setData(self::OPENID, $openId);
    }

    /**
     * @inheritDoc
     */
    public function getUnionId()
    {
        return parent::getData(self::UNIOIONID);
    }

    /**
     * @inheritDoc
     */
    public function setUnionId($unionId)
    {
        return $this->setData(self::UNIOIONID, $unionId);
    }

    /**
     * @inheritDoc
     */
    public function getApplication()
    {
        return parent::getData(self::APPLICATION);
    }

    /**
     * @inheritDoc
     */
    public function setApplication($application)
    {
        return $this->setData(self::APPLICATION, $application);
    }

    /**
     * @inheritDoc
     */
    public function getPlatform()
    {
        return parent::getData(self::PLATFORM);
    }

    /**
     * @inheritDoc
     */
    public function setPlatform($platform)
    {
        return $this->setData(self::PLATFORM, $platform);
    }

    /**
     * @inheritDoc
     */
    public function getUniqueHash()
    {
        return parent::getData(self::UNIQUE_HASH);
    }

    /**
     * @inheritDoc
     */
    public function setUniqueHash($uniqueHash)
    {
        return $this->setData(self::UNIQUE_HASH, $uniqueHash);
    }


    /**
     * @inheritDoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(
        \AlbertMage\Customer\Api\Data\SocialExtensionInterface $extensionAttributes
    ) {
        $this->_setExtensionAttributes($extensionAttributes);
    }

}
