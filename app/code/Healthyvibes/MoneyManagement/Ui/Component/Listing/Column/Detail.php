<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Detail
 */
class Detail extends Column
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * Detail constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $data['editUrlPath'];
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                $indexField = $this->getData('config/indexField');
                if ($indexField && isset($item[$indexField])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item[$indexField]]),
                        'label' => __('Edit')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
