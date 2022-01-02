<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Customer\Model\ResourceModel\Social;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AlbertMage\Customer\Model\ResourceModel\Social;

/**
 * Class Collection
 * @author Suman Kar(suman.jis@gmail.com)
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