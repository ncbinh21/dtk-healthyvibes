<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Healthyvibes\Directory\Setup\Patch\Data;

use Healthyvibes\Directory\Model\ResourceModel\Address\Source\City;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\Patch\Data\DefaultCustomerGroupsAndAttributes;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
* Patch is mechanism, that allows to do atomic upgrade data changes
*/
class CreateCityIdAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeResource
     */
    private $attributeResource;


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

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->updateAttribute(
            'customer_address',
            'city',
            'backend_model',
            \Healthyvibes\Directory\Model\ResourceModel\Address\Backend\City::class
        );
        $cityIdAttrInfo = [
            'type' => 'static',
            'label' => 'City/District',
            'input' => 'hidden',
            'source' => City::class,
            'required' => false,
            'sort_order' => 103,
            'position' => 103,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
        ];

        $customerSetup->addAttribute('customer_address', 'city_id', $cityIdAttrInfo);
        $cityIdAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'city_id');
        $usedInForms = [
            'adminhtml_customer_address',
            'customer_address_edit',
            'customer_register_address',
        ];
        foreach ($usedInForms as $formCode) {
            $data[] = ['form_code' => $formCode, 'attribute_id' => $cityIdAttribute->getId()];
        }

        $this->moduleDataSetup->getConnection()
            ->insertMultiple($this->moduleDataSetup->getTable('customer_form_attribute'), $data);
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
        return [
            DefaultCustomerGroupsAndAttributes::class,
        ];
    }
}
