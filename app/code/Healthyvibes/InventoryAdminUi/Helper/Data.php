<?php

declare(strict_types=1);

namespace Healthyvibes\InventoryAdminUi\Helper;

use Magento\Framework\App\ResourceConnection;

class Data
{
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Data constructor.
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $regionId
     * @return array|mixed
     */
    public function getSourceFromRegion($regionId)
    {
        $selectRegion = $this->resourceConnection->getConnection()->select()
            ->from('directory_country_region')
            ->where('region_id = ?', $regionId)
            ->limit(1);
        $region = $this->resourceConnection->getConnection()->fetchRow($selectRegion);
        $sourceSelect = [];
        if (isset($region['domain_id'])) {
            $select = $this->resourceConnection->getConnection()->select()
                ->from('inventory_source')
                ->where('domain_id = ?', $region['domain_id'])
                ->limit(1);
            $sourceSelect = $this->resourceConnection->getConnection()->fetchRow($select);
        }
        return $sourceSelect;
    }

    /**
     * @param $sourceCode
     * @return mixed
     */
    public function getSourceFromSourceCode($sourceCode)
    {
        $select = $this->resourceConnection->getConnection()->select()
            ->from('inventory_source')
            ->where('source_code = ?', $sourceCode)
            ->limit(1);
        return $this->resourceConnection->getConnection()->fetchRow($select);
    }
}
