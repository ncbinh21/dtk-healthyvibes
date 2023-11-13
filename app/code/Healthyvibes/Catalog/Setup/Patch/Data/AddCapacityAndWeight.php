<?php
declare(strict_types=1);

namespace Healthyvibes\Catalog\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as EavAttribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Psr\Log\LoggerInterface;

class AddCapacityAndWeight implements DataPatchInterface
{
    const ATTRIBUTE_CAPACITY = 'hv_capacity';
    const ATTRIBUTE_WEIGHT = 'hv_weight';

    /**
     * @var array
     */
    protected array $optionCollection = [];
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $attrOptionCollectionFactory;

    /**
     * @var Config
     */
    private Config $eavConfig;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * AddCustomOrderStatus constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param CollectionFactory $attrOptionCollectionFactory
     * @param Config $eavConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        CollectionFactory $attrOptionCollectionFactory,
        Config $eavConfig,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attrOptionCollectionFactory = $attrOptionCollectionFactory;
        $this->eavConfig = $eavConfig;
        $this->logger = $logger;
    }

    /**
     * @return AddCapacityAndWeight|void
     */
    public function apply()
    {
        try {
            $productTypes = implode(',', [Type::TYPE_SIMPLE, Type::TYPE_VIRTUAL, Configurable::TYPE_CODE]);
            //add ATTRIBUTE_CAPACITY
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $eavSetup->addAttribute(
                Product::ENTITY,
                self::ATTRIBUTE_CAPACITY,
                [
                    'type' => 'int',
                    'label' => 'HV Capacity',
                    'input' => 'select',
                    'required' => false,
                    'user_defined' => true,
                    'searchable' => true,
                    'filterable' => true,
                    'comparable' => true,
                    'visible_in_advanced_search' => true,
                    'apply_to' => $productTypes,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => false,
                    'option' => [
                        'values' => $this->getHvCapacityData()
                    ]
                ]
            );
            $this->eavConfig->clear();
            $attribute = $this->eavConfig->getAttribute('catalog_product', self::ATTRIBUTE_CAPACITY);
            $this->convertAttributeToSwatches($attribute);

            //Add ATTRIBUTE_WEIGHT
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $eavSetup->addAttribute(
                Product::ENTITY,
                self::ATTRIBUTE_WEIGHT,
                [
                    'type' => 'int',
                    'label' => 'HV Weight',
                    'input' => 'select',
                    'required' => false,
                    'user_defined' => true,
                    'searchable' => true,
                    'filterable' => true,
                    'comparable' => true,
                    'visible_in_advanced_search' => true,
                    'apply_to' => $productTypes,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => false,
                    'option' => [
                        'values' => $this->getHvWeightData()
                    ]
                ]
            );
            $this->eavConfig->clear();
            $attribute = $this->eavConfig->getAttribute('catalog_product', self::ATTRIBUTE_WEIGHT);
            $this->convertAttributeToSwatches($attribute);
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }

    /**
     * @return array
     */
    private function getHvCapacityData()
    {
        return [
            '10ml',
            '20ml',
            '30ml',
            '50ml',
            '70ml',
            '100ml',
            '200ml',
            '250ml',
            '300ml',
            '350ml',
            '400ml',
            '500ml',
            '550ml',
            '600ml',
            '700ml',
            '800ml',
            '900ml',
            '1-lit',
            '1.9-lit',
            '2-lit',
            '3-lit',
            '4.6-lit',
        ];
    }

    /**
     * @return array
     */
    private function getHvWeightData()
    {
        return [
            '50g',
            '100g',
            '120g',
            '150g',
            '200g',
            '250g',
            '300g',
            '400g',
            '450g',
            '500g',
            '550g',
            '600g',
            '700g',
            '800g',
            '900g',
            '1-kg',
            '1.4-kg',
            '2-kg',
            '3-kg',
            '4-kg',
            '5-kg',
        ];
    }

    /**
     * @param $attribute
     */
    public function convertAttributeToSwatches($attribute)
    {
        if (!$attribute) {
            return;
        }
        $attributeData['option'] = $this->addExistingOptions($attribute);
        $attributeData['frontend_input'] = 'select';
        $attributeData['swatch_input_type'] = 'text';
        $attributeData['update_product_preview_image'] = 1;
        $attributeData['use_product_image_for_swatch'] = 0;
        $attributeData['optiontext'] = $this->getOptionSwatch($attributeData);
        //$attributeData['defaulttext'] = $this->getOptionDefaultText($attributeData);
        $attributeData['swatchtext'] = $this->getOptionSwatchText($attributeData);
        $this->logger->log(100, print_r($attributeData, true));
        $attribute->addData($attributeData);
        $attribute->save();
    }

    /**
     * @param EavAttribute $attribute
     * @return array
     */
    private function addExistingOptions(EavAttribute $attribute): array
    {
        $options = [];
        $attributeId = $attribute->getId();
        if ($attributeId) {
            $this->loadOptionCollection($attributeId);
            /** @var \Magento\Eav\Model\Entity\Attribute\Option $option */
            foreach ($this->optionCollection[$attributeId] as $option) {
                $options[$option->getId()] = $option->getValue();
            }
        }
        return $options;
    }

    /**
     * @param int $attributeId
     * @return void
     */
    private function loadOptionCollection($attributeId)
    {
        if (empty($this->optionCollection[$attributeId])) {
            $this->optionCollection[$attributeId] = $this->attrOptionCollectionFactory->create()
                ->setAttributeFilter($attributeId)
                ->setPositionOrder('asc', true)
                ->load();
        }
    }

    /**
     * @param array $attributeData
     * @return array
     */
    private function getOptionSwatch(array $attributeData): array
    {
        $optionSwatch = ['order' => [], 'value' => [], 'delete' => []];
        $i = 0;
        foreach ($attributeData['option'] as $optionKey => $optionValue) {
            $optionSwatch['delete'][$optionKey] = '';
            $optionSwatch['order'][$optionKey] = (string)$i++;
            $optionSwatch['value'][$optionKey] = [$optionValue, ''];
        }
        return $optionSwatch;
    }

    /**
     * @param array $attributeData
     * @return array
     */
    private function getOptionDefaultText(array $attributeData): array
    {
        $optionSwatch = $this->getOptionSwatchText($attributeData);
        return [array_keys($optionSwatch['value'])[0]];
    }

    /**
     * @param array $attributeData
     * @return array
     */
    private function getOptionSwatchText(array $attributeData): array
    {
        $optionSwatch = ['value' => []];
        foreach ($attributeData['option'] as $optionKey => $optionValue) {
            $optionSwatch['value'][$optionKey] = [$optionValue, ''];
        }
        return $optionSwatch;
    }

    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
