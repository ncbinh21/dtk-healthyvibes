<?php

namespace Healthyvibes\MoneyManagement\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface MoneyManagementSearchResultsInterface
 */
interface MoneyManagementSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get money management list.
     *
     * @return \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface[]
     */
    public function getItems();

    /**
     * Set money management list.
     *
     * @param \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
