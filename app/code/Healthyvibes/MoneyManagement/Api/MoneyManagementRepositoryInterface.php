<?php

namespace Healthyvibes\MoneyManagement\Api;

/**
 * Interface MoneyManagementRepositoryInterface
 */
interface MoneyManagementRepositoryInterface
{
    /**
     * Save Item
     *
     * @param \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface $moneyManagement
     * @return \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface $moneyManagement);

    /**
     * Get item by ID
     *
     * @param int $entityId
     * @return \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $entityId);

    /**
     * Delete item by ID
     *
     * @param \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface $moneyManagement
     * @return bool
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(\Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface $moneyManagement);

    /**
     * Load item data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Healthyvibes\MoneyManagement\Api\Data\MoneyManagementSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria);
}
