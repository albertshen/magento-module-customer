<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api\Data;

/**
 * Interface for customer social account search results.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SocialSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get customer social list.
     *
     * @return \AlbertMage\Customer\Api\Data\SocialInterface[]
     */
    public function getItems();

    /**
     * Set customer social list.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
