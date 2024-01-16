<?php
declare(strict_types = 1);

namespace Healthyvibes\MoneyManagement\Model;

use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class MoneyManagementSearchResults
 */
class MoneyManagementSearchResults extends SearchResults implements MoneyManagementSearchResultsInterface
{
}
