<?php
namespace Healthyvibes\Banner\Model;

use Healthyvibes\Banner\Api\BannerRepositoryInterface;
use Healthyvibes\Banner\Api\Data\BannerInterface;
use Healthyvibes\Banner\Model\BannerFactory;
use Healthyvibes\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class BannerRepository implements BannerRepositoryInterface
{
    protected $objectFactory;
    protected $dataBannerFactory;
    protected $dataObjectHelper;
    protected $dataObjectProcessor;
    protected $collectionFactory;
    private $searchResultsFactory;
    public function __construct(
        BannerFactory $objectFactory,
        CollectionFactory $collectionFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        \Healthyvibes\Banner\Api\Data\BannerInterfaceFactory $dataBannerFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->objectFactory        = $objectFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBannerFactory = $dataBannerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function getById($id)
    {
        $banner = $this->objectFactory->create();
        $banner->load($id);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Banner with id "%1" does not exist.', $id));
        }
        return $banner;
    }
    public function delete(BannerInterface $banner)
    {
        try {
            $banner->delete();
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
