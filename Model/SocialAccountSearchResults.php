<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\Customer\Model;

use AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Social account search results.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccountSearchResults extends SearchResults implements SocialAccountSearchResultsInterface
{
}
