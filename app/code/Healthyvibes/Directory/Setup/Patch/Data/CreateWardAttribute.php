<?php

namespace Healthyvibes\Directory\Setup\Patch\Data;

use Healthyvibes\Directory\Model\ResourceModel\Address\Source\City;
use Healthyvibes\Directory\Model\ResourceModel\Address\Source\Ward;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\Patch\Data\DefaultCustomerGroupsAndAttributes;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
* Patch is mechanism, that allows to do atomic upgrade data changes
*/
class CreateWardAttribute implements DataPatchInterface
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
     * AddWardAttribute constructor.
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
        $customerSetup->removeAttribute(
            'customer_address',
            'city_id'
        );
        $wardIdAttrInfo = [
            'type' => 'static',
            'label' => 'Ward Name',
            'input' => 'hidden',
            'source' => Ward::class,
            'required' => true,
            'sort_order' => 103,
            'position' => 103,
            'system'   => 0
        ];

        $customerSetup->addAttribute('customer_address', 'ward_id', $wardIdAttrInfo);
        $wardIdAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'ward_id');
        $usedInForms = [
            'adminhtml_customer_address',
            'customer_address_edit',
            'customer_register_address',
        ];
        $wardIdAttribute->setData('used_in_forms', $usedInForms);
        $wardIdAttribute->getResource()->save($wardIdAttribute);

        $customerSetup->addAttribute('customer_address', 'ward', [
            'type'          => 'varchar',
            'label'         => 'Ward Name',
            'input'         => 'hidden',
            'required'      =>  true,
            'sort_order'    =>  107,
            'position'      =>  107,
            'system'        =>  0,
        ]);

        $wardAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'ward');
        $wardAttribute->setData('used_in_forms', $usedInForms);
        $wardAttribute->getResource()->save($wardAttribute);
        $cityIdAttrInfo = [
            'type' => 'static',
            'label' => 'City/District',
            'input' => 'hidden',
            'source' => City::class,
            'required' => true,
            'sort_order' => 107,
            'position' => 107,
            'system' =>  0,
        ];

        $customerSetup->addAttribute('customer_address', 'city_id', $cityIdAttrInfo);
        $cityIdAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'city_id');
        $cityIdAttribute->setData('used_in_forms', $usedInForms);
        $cityIdAttribute->getResource()->save($cityIdAttribute);
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
