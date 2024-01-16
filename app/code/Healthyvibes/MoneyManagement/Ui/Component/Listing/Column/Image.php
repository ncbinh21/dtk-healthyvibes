<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Ui\Component\Listing\Column;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface;

/**
 * Component Image
 */
class Image extends Column
{
    const NAME = 'image';

    /** @var MoneyManagementRepositoryInterface */
    protected MoneyManagementRepositoryInterface $moneyManagementRepository;

    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /**
     * Image constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param MoneyManagementRepositoryInterface $moneyManagementRepository
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        MoneyManagementRepositoryInterface $moneyManagementRepository,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->moneyManagementRepository = $moneyManagementRepository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare data source
     *
     * @param array $dataSource
     * @return array
     * @throws LocalizedException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $model = $this->moneyManagementRepository->get((int)$item[MoneyManagementInterface::ENTITY_ID]);
                $mediaUrl = $model->getImageUrl();
                if ($mediaUrl) {
                    $item[$fieldName] = '<img src="' . $mediaUrl . '" width="auto" style="max-height: 150px">';
                }
            }
        }

        return $dataSource;
    }
}
