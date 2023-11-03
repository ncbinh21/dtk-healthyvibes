<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Healthyvibes\InventoryAdminUi\Model\OptionSource;

use Healthyvibes\Directory\Model\ResourceModel\City\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Provide option values for UI
 *
 * @api
 */
class City implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $cityCollectionFactory;

    /**
     * Source data
     *
     * @var null|array
     */
    private $sourceData;

    /**
     * @param CollectionFactory $cityCollectionFactory
     */
    public function __construct(CollectionFactory $cityCollectionFactory)
    {
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        if (null === $this->sourceData) {
            $cityCollection = $this->cityCollectionFactory->create();
            $this->sourceData = $cityCollection->toOptionArray();
        }
        return $this->sourceData;
    }
}
