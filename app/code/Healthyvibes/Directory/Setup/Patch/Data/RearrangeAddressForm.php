<?php

namespace Healthyvibes\Directory\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class RearrangeAddressForm implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private CustomerSetupFactory $customerSetupFactory;
    private AttributeResource $attributeResource;

    /**
     * AddCityIdAttribute constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeResource $attributeResource
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeResource $attributeResource,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeResource = $attributeResource;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->updateAttribute(
            'customer_address',
            'city',
            'sort_order',
            105
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'city_id',
            'sort_order',
            110
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'ward',
            'sort_order',
            115
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'ward_id',
            'sort_order',
            120
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'street',
            'sort_order',
            125
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'telephone',
            'sort_order',
            125
        );

        $customerSetup->updateAttribute(
            'customer_address',
            'postcode',
            'sort_order',
            130
        );
    }
}
