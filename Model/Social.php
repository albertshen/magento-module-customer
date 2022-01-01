<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use AlbertMage\Customer\Api\Data\SocialInterface;

/**
 * Class Social
 * @author Albert Shen(albertshen1206@gmail.com)
 */
class Social extends AbstractExtensibleModel implements SocialInterface
{

    /**
     * Customer entity
     *
     * @var Customer
     */
    protected $_customer;

    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * Initialize address model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Customer\Model\ResourceModel\Social::class);

        $this->_customerFactory = \Magento\Framework\App\ObjectManager::getInstance()->create(\Magento\Customer\Model\CustomerFactory::class);
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
     * Retrieve address customer
     *
     * @return Customer|false
     */
    public function getCustomer()
    {
        if (!$this->getCustomerId()) {
            return false;
        }
        if (empty($this->_customer)) {
            $this->_customer = $this->_createCustomer()->load($this->getCustomerId());
        }
        return $this->_customer;
    }

    /**
     * Create customer model
     *
     * @return Customer
     */
    protected function _createCustomer()
    {
        return $this->_customerFactory->create();
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
        return $this->setData(self::UNIQUE_HASH, $platform);
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
