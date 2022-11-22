<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model\ResourceModel\Social;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AlbertMage\Customer\Model\ResourceModel\Social;

/**
 * Class Collection
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\Customer\Model\Social::class,
            Social::class);
    }
}