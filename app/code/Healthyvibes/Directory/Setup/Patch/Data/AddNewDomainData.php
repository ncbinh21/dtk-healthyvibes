<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Healthyvibes\Directory\Setup\Patch\Data;

use Healthyvibes\Directory\Setup\RegionCityZipcodeDataInstaller;
use Healthyvibes\Directory\Setup\RegionCityZipcodeDataInstallerFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Patch is mechanism, that allows to do atomic upgrade data changes
 */
class AddNewDomainData implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var RegionCityZipcodeDataInstallerFactory
     */
    private $regionCityZipcodeDataInstallerFactory;

    /**
     * AddNewDataForVietnam constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param RegionCityZipcodeDataInstallerFactory $regionCityZipcodeDataInstallerFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RegionCityZipcodeDataInstallerFactory $regionCityZipcodeDataInstallerFactory

    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->regionCityZipcodeDataInstallerFactory = $regionCityZipcodeDataInstallerFactory;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        /** @var RegionCityZipcodeDataInstaller $regionCityDataInstaller */
        $regionCityDataInstaller = $this->regionCityZipcodeDataInstallerFactory->create();
        $regionCityDataInstaller->addMappingDomainWithRegion($this->moduleDataSetup->getConnection(), $this->mappingDomainData());
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [AddNewCityData::class, AddNewWardData::class];
    }
    /**
     * @return array[]
     */
    public function mappingDomainData()
    {
        return [
            ["VN","An Giang","mien-nam"],
            ["VN","Bà Rịa - Vũng Tàu","mien-nam"],
            ["VN","Bắc Giang","mien-bac"],
            ["VN","Bắc Kạn","mien-bac"],
            ["VN","Bạc Liêu","mien-nam"],
            ["VN","Bắc Ninh","mien-bac"],
            ["VN","Bến Tre","mien-nam"],
            ["VN","Bình Định","mien-nam"],
            ["VN","Bình Dương","mien-nam"],
            ["VN","Bình Phước","mien-nam"],
            ["VN","Bình Thuận","mien-nam"],
            ["VN","Cà Mau","mien-nam"],
            ["VN","Cần Thơ","mien-nam"],
            ["VN","Cao Bằng","mien-bac"],
            ["VN","Đà Nẵng","mien-nam"],
            ["VN","Đắk Lắk","mien-nam"],
            ["VN","Đắk Nông","mien-nam"],
            ["VN","Điện Biên","mien-bac"],
            ["VN","Đồng Nai","mien-nam"],
            ["VN","Đồng Tháp","mien-nam"],
            ["VN","Gia Lai","mien-nam"],
            ["VN","Hà Giang","mien-bac"],
            ["VN","Hà Nam","mien-bac"],
            ["VN","Hà Nội","mien-bac"],
            ["VN","Hà Tĩnh","mien-bac"],
            ["VN","Hải Dương","mien-bac"],
            ["VN","Hải Phòng","mien-bac"],
            ["VN","Hậu Giang","mien-nam"],
            ["VN","Hồ Chí Minh","mien-nam"],
            ["VN","Hòa Bình","mien-bac"],
            ["VN","Hưng Yên","mien-bac"],
            ["VN","Khánh Hòa","mien-nam"],
            ["VN","Kiên Giang","mien-nam"],
            ["VN","Kon Tum","mien-nam"],
            ["VN","Lai Châu","mien-bac"],
            ["VN","Lâm Đồng","mien-nam"],
            ["VN","Lạng Sơn","mien-bac"],
            ["VN","Lào Cai","mien-bac"],
            ["VN","Long An","mien-nam"],
            ["VN","Nam Định","mien-bac"],
            ["VN","Nghệ An","mien-bac"],
            ["VN","Ninh Bình","mien-bac"],
            ["VN","Ninh Thuận","mien-nam"],
            ["VN","Phú Thọ","mien-bac"],
            ["VN","Phú Yên","mien-nam"],
            ["VN","Quảng Bình","mien-bac"],
            ["VN","Quảng Nam","mien-nam"],
            ["VN","Quảng Ngãi","mien-nam"],
            ["VN","Quảng Ninh","mien-bac"],
            ["VN","Quảng Trị","mien-bac"],
            ["VN","Sóc Trăng","mien-nam"],
            ["VN","Sơn La","mien-bac"],
            ["VN","Tây Ninh","mien-nam"],
            ["VN","Thái Bình","mien-bac"],
            ["VN","Thái Nguyên","mien-bac"],
            ["VN","Thanh Hóa","mien-bac"],
            ["VN","Thừa Thiên Huế","mien-bac"],
            ["VN","Tiền Giang","mien-nam"],
            ["VN","Trà Vinh","mien-nam"],
            ["VN","Tuyên Quang","mien-bac"],
            ["VN","Vĩnh Long","mien-nam"],
            ["VN","Vĩnh Phúc","mien-bac"],
            ["VN","Yên Bái","mien-bac"]
        ];
    }
}

