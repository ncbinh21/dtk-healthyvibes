<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Ui\DataProvider\MoneyManagement;

use Exception;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterfaceFactory;
use Healthyvibes\MoneyManagement\Model\Image\FileInfo;
use Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement\CollectionFactory as MoneyManagementCollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var MoneyManagementRepositoryInterface
     */
    protected MoneyManagementRepositoryInterface $moneyManagementRepository;

    /**
     * @var MoneyManagementInterfaceFactory
     */
    protected MoneyManagementInterfaceFactory $moneyManagement;

    /**
     * @var FileInfo
     */
    protected FileInfo $fileInfo;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param MoneyManagementCollectionFactory $collectionFactory
     * @param MoneyManagementRepositoryInterface $moneyManagementRepository
     * @param RequestInterface $request
     * @param MoneyManagementInterfaceFactory $moneyManagement
     * @param FileInfo $fileInfo
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        MoneyManagementCollectionFactory $collectionFactory,
        MoneyManagementRepositoryInterface $moneyManagementRepository,
        RequestInterface $request,
        MoneyManagementInterfaceFactory $moneyManagement,
        FileInfo $fileInfo,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->moneyManagementRepository = $moneyManagementRepository;
        $this->request = $request;
        $this->moneyManagement = $moneyManagement;
        $this->fileInfo = $fileInfo;
    }

    /**
     * Get current model
     *
     * @return MoneyManagementInterface
     */
    public function getModel()
    {
        $id = $this->request->getParam('id');
        try {
            $model = $this->moneyManagementRepository->get((int) $id);
        } catch (Exception $e) {
            $model = $this->moneyManagement->create();
        }
        return $model;
    }

    /**
     * Get data
     *
     * @return array
     * @throws FileSystemException
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getData()
    {
        $data = [];
        $model = $this->getModel();
        if ($model->getEntityId()) {
            $modelData = $model->getData();
            $imageFileName = $model->getImage();

            if ($imageFileName && $this->fileInfo->isExist($imageFileName)) {
                $stat = $this->fileInfo->getStat($imageFileName);
                $mime = $this->fileInfo->getMimeType($imageFileName);

                $modelData[MoneyManagementInterface::IMAGE] = [];
                $modelData[MoneyManagementInterface::IMAGE][0]['name'] = basename($imageFileName);
                if ($this->fileInfo->isBeginsWithMediaDirectoryPath($imageFileName)) {
                    $modelData[MoneyManagementInterface::IMAGE][0]['url'] = $imageFileName;
                } else {
                    $modelData[MoneyManagementInterface::IMAGE][0]['url'] = $model->getImageUrl();
                }

                $modelData[MoneyManagementInterface::IMAGE][0]['size'] = isset($stat) ? $stat['size'] : 0;
                $modelData[MoneyManagementInterface::IMAGE][0]['type'] = $mime;
            } else {
                $modelData[MoneyManagementInterface::IMAGE] = "";
            }

            $data[""] = $modelData;
        }

        return $data;
    }
}
