<?php

namespace Healthyvibes\InventoryAdminUi\Plugin\InventoryAdminUi\Ui\DataProvider;

use Healthyvibes\Directory\Model\City;
use Healthyvibes\Directory\Model\Domain;
use Healthyvibes\Directory\Model\Ward;
use Magento\Framework\App\ResourceConnection;
use Magento\InventoryAdminUi\Ui\DataProvider\SourceDataProvider;

class SourceDataProviderPlugin
{
    const SHOP_ID_GHN = 'shop_id_ghn';

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * SourceDataProviderPlugin constructor.
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param SourceDataProvider $sourceDataProvider
     * @param $result
     * @return mixed
     */
    public function afterGetData(SourceDataProvider $sourceDataProvider, $result)
    {
        if (SourceDataProvider::SOURCE_FORM_NAME === $sourceDataProvider->getName()) {
            if (count($result) == 1) {
                foreach ($result as $sourceCode => $source) {
                    $select = $this->resourceConnection->getConnection()->select()
                        ->from('inventory_source')
                        ->where('source_code = ?', $sourceCode);
                    $sourceSelect = $this->resourceConnection->getConnection()->fetchRow($select);
                    $result[$sourceCode]['general'][Domain::DOMAIN_ID] = $sourceSelect[Domain::DOMAIN_ID];
                    $result[$sourceCode]['general'][City::CITY_ID] = $sourceSelect[City::CITY_ID];
                    $result[$sourceCode]['general'][Ward::WARD_ID] = $sourceSelect[Ward::WARD_ID];
                    $result[$sourceCode]['general'][self::SHOP_ID_GHN] = $sourceSelect[self::SHOP_ID_GHN];
                }
            }
        }
        return $result;
    }
}
