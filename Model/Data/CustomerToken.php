<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model\Data;

use AlbertMage\Customer\Api\Data\CustomerTokenInterface;
use Magento\Framework\DataObject;

/**
 * Class Customer Token
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class CustomerToken extends DataObject implements CustomerTokenInterface
{

    /**
     * @inheritDoc
     */
    public function getToken()
    {
        return $this->getData(self::TOKEN);
    }

    /**
     * @inheritDoc
     */
    public function setToken($token)
    {
        return $this->setData(self::TOKEN, $token);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

}
