<?php

namespace Healthyvibes\Banner\Model\ResourceModel\Banner\Relation\CustomerGroup;

use Healthyvibes\Banner\Model\ResourceModel\Banner;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Banner
     */
    protected $resourceBanner;

    /**
     * @param MetadataPool $metadataPool
     * @param Banner $resourceBanner
     */
    public function __construct(
        MetadataPool $metadataPool,
        Banner $resourceBanner
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceBanner = $resourceBanner;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $connection = $this->resourceBanner->getConnection();

            $customerGroupIds = $connection
                ->fetchCol(
                    $connection
                        ->select()
                        ->from($this->resourceBanner->getTable('healthyvibes_banner_customer_group'), ['customer_group_id'])
                        ->where('banner_id = ?', (int)$entity->getId())
                );

            $entity->setData('customer_group_id', $customerGroupIds);
        }
        return $entity;
    }
}
