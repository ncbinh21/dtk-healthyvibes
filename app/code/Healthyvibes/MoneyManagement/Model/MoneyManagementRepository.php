<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementSearchResultsInterfaceFactory;
use Healthyvibes\MoneyManagement\Model\MoneyManagementFactory;
use Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement as ResourceMoneyManagement;
use Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement\CollectionFactory as ResourceMoneyCollectionFactory;

/**
 * Repository Money Management
 */
class MoneyManagementRepository implements MoneyManagementRepositoryInterface
{
    /**
     * @var MoneyManagementFactory
     */
    protected MoneyManagementFactory $moneyManagementModel;

    /**
     * @var ResourceMoneyManagement
     */
    protected ResourceMoneyManagement $resourceMoneyManagement;

    /**
     * @var ResourceMoneyCollectionFactory
     */
    protected ResourceMoneyCollectionFactory $resourceMoneyManagementCollection;

    /**
     * @var CollectionProcessor
     */
    protected CollectionProcessor $collectionProcessor;

    /**
     * @var MoneyManagementSearchResultsInterfaceFactory
     */
    protected MoneyManagementSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @param MoneyManagementFactory $moneyManagementModel
     * @param ResourceMoneyManagement $resourceMoneyManagement
     * @param ResourceMoneyCollectionFactory $resourceMoneyManagementCollection
     * @param CollectionProcessor $collectionProcessor
     * @param MoneyManagementSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        MoneyManagementFactory $moneyManagementModel,
        ResourceMoneyManagement $resourceMoneyManagement,
        ResourceMoneyCollectionFactory $resourceMoneyManagementCollection,
        CollectionProcessor $collectionProcessor,
        MoneyManagementSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->moneyManagementModel = $moneyManagementModel;
        $this->resourceMoneyManagement = $resourceMoneyManagement;
        $this->resourceMoneyManagementCollection = $resourceMoneyManagementCollection;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function save(MoneyManagementInterface $moneyManagement)
    {
        try {
            $this->resourceMoneyManagement->save($moneyManagement);
            return $this->get((int) $moneyManagement->getEntityId());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save item: %1', $e->getMessage()), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function get(int $entityId)
    {
        $model = $this->moneyManagementModel->create();
        $this->resourceMoneyManagement->load($model, $entityId);
        if (!$model->getEntityId()) {
            throw NoSuchEntityException::singleField(MoneyManagementInterface::ENTITY_ID, $entityId);
        }
        return $model;
    }

    /**
     * @inheritdoc
     */
    public function delete(MoneyManagementInterface $moneyManagement)
    {
        try {
            $this->resourceMoneyManagement->delete($moneyManagement);
        } catch (\Exception $e) {
            throw new StateException(__('Cannot delete item with id %1', $moneyManagement->getEntityId()), $e);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->resourceMoneyManagementCollection->create();
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
