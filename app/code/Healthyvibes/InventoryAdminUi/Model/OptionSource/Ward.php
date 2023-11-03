<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Healthyvibes\InventoryAdminUi\Model\OptionSource;

use Healthyvibes\Directory\Model\ResourceModel\Ward\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Provide option values for UI
 *
 * @api
 */
class Ward implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $wardCollectionFactory;

    /**
     * Source data
     *
     * @var null|array
     */
    private $sourceData;

    /**
     * @param CollectionFactory $wardCollectionFactory
     */
    public function __construct(CollectionFactory $wardCollectionFactory)
    {
        $this->wardCollectionFactory = $wardCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        if (null === $this->sourceData) {
            $wardCollection = $this->wardCollectionFactory->create();
            $this->sourceData = $wardCollection->toOptionArray();
        }
        return $this->sourceData;
    }
}
