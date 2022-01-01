<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AlbertMage\Customer\Model;

use AlbertMage\Customer\Api\Data\SocialSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Social search results.
 */
class SocialSearchResults extends SearchResults implements SocialSearchResultsInterface
{
}
