<?php

namespace Healthyvibes\Directory\Setup;

use Healthyvibes\Directory\Model\ResourceModel\City\CollectionFactory;
use Magento\Directory\Helper\Data;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;

class RegionCityZipcodeDataInstaller
{
    const DOMAIN = [
        "mien-bac" => "Miền Bắc",
        "mien-nam" => "Miền Nam"
    ];
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $resourceConnection;

    /**
     * @var Data
     */
    private Data $data;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $cityCollectionFactory;

    /**
     * RegionCityZipcodeDataInstaller constructor.
     * @param ResourceConnection $resourceConnection
     * @param Data $data
     * @param CollectionFactory $cityCollectionFactory
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        Data $data,
        CollectionFactory $cityCollectionFactory
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->data = $data;
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    /**
     * @param AdapterInterface $adapter
     * @param array $data
     */
    public function addCountryRegionsCitiesWithZipcode(AdapterInterface $adapter, array $data)
    {
        foreach ($data as $row) {
            $bind = ['country_id' => $row[0], 'code' => $row[1], 'default_name' => $row[2]];
            $adapter->insert($this->resourceConnection->getTableName('directory_country_region'), $bind);
            $regionId = $adapter->lastInsertId($this->resourceConnection->getTableName('directory_country_region'));
            $bind = ['locale' => 'en_US', 'region_id' => $regionId, 'name' => $row[2]];
            $adapter->insert($this->resourceConnection->getTableName('directory_country_region_name'), $bind);
            $cityData = $row[3];
            foreach ($cityData as $cityRow) {
                $bind = ['region_id' => $regionId, 'code' => $cityRow[0], 'default_name' => $cityRow[1], 'pos_code' => $cityRow[2]];
                $adapter->insert($this->resourceConnection->getTableName('healthyvibes_directory_region_city'), $bind);
            }
        }
    }

    /**
     * @param AdapterInterface $adapter
     * @param array $data
     */
    public function addMappingDomainWithRegion(AdapterInterface $adapter, array $data)
    {
        foreach (self::DOMAIN as $code => $domain) {
            $bind = ['code' => $code, 'default_name' => $domain];
            $adapter->insert($this->resourceConnection->getTableName('healthyvibes_directory_region_domain'), $bind);
        }
        $query = $adapter->select()
            ->from($this->resourceConnection->getTableName('healthyvibes_directory_region_domain'));
        $domainData = $adapter->fetchAll($query);
        foreach ($domainData as $item) {
            $domainMapping[$item['code']] = $item['domain_id'];
        }
        foreach ($data as $row) {
            $adapter->update(
                $this->resourceConnection->getTableName('directory_country_region'),
                [
                    'domain_id' => $domainMapping[$row[2]],
                ],
                [
                    'default_name = ?' => $row[1]
                ]
            );
        }
    }

    /**
     * @param AdapterInterface $adapter
     * @param array $data
     * @return void
     */
    public function updateCityCode(AdapterInterface $adapter, array $data)
    {
        $adapter->delete(
            $this->resourceConnection->getTableName('healthyvibes_directory_region_city'),
            [
                'pos_code = ?' => 'VN-017'
            ]
        );
        $adapter->delete(
            $this->resourceConnection->getTableName('healthyvibes_directory_region_city'),
            [
                'pos_code = ?' => 'VN-642'
            ]
        );
        $bind = ['region_id' => 2499, 'code' => 81000, 'default_name' => 'Thành phố Hồng Ngự', 'pos_code' => 'VN-715'];
        $adapter->insert($this->resourceConnection->getTableName('healthyvibes_directory_region_city'), $bind);
        $needUpdateNames = [
            'VN-067' => 'Thị xã Hoài Nhơn',
            'VN-103' => 'Huyện Phú Quý',
            'VN-141' => 'Huyện Hoàng Sa',
            'VN-067' => 'Thị xã Hoài Nhơn',
            'VN-193' => 'Thị xã Hồng Ngự',
            'VN-280' => 'Thị xã Kinh Môn',
            'VN-503' => 'Thị xã Đông Hòa',
            'VN-301' => 'Huyện Bạch Long Vĩ',
        ];
        foreach ($needUpdateNames as $pos_code => $name) {
            $adapter->update(
                $this->resourceConnection->getTableName('healthyvibes_directory_region_city'),
                [
                    'default_name' => $name,
                ],
                [
                    'pos_code = ?' => $pos_code
                ]
            );
        }
        foreach ($data as $row) {
            $adapter->update(
                $this->resourceConnection->getTableName('healthyvibes_directory_region_city'),
                [
                    'ghn_code' => $row[0]
                ],
                [
                    'default_name like "' . $row[1] . '"',
                    'code = ?' => $row[2]
                ]
            );
        }
    }

    /**
     * @param AdapterInterface $adapter
     * @param array $data
     */
    public function addNewWardDataWithCity(AdapterInterface $adapter, array $data)
    {
        foreach ($data as $row) {
            $cityId = $this->getCityId($row[0]);
            $bind = ['city_id' => $cityId, 'code' => $row[1], 'default_name' => $row[2]];
            $adapter->insert($this->resourceConnection->getTableName('healthyvibes_directory_region_ward'), $bind);
        }
    }

    /**
     * @param $cityCode
     * @return int
     */
    private function getCityId($cityCode)
    {
        $cityId = 0;
        /** @var $collection \Healthyvibes\Directory\Model\ResourceModel\City\Collection */
        $collection = $this->cityCollectionFactory->create();
        $collection->addFieldToFilter('ghn_code', $cityCode);
        if ($collection && $collection->getSize() > 0) {
            $cityId = $collection->getFirstItem()->getCityId();
        }
        return $cityId;
    }
}
