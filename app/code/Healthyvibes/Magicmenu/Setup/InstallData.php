<?php

namespace Healthyvibes\Magicmenu\Setup;

use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {


        /** @var CategorySetup $categorySetup */

        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'magic_label',
            [
            'group' => 'Healthyvibes',
            'label' => 'Label',
            'input' => 'text',
            'type' => 'varchar',
            'required' => false,
            'frontend_class' => 'validate-length maximum-length-255',
            'note' => 'Example: New,Hot,... Maximum 255 chars',
            'sort_order' => 1,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'magic_thumbnail',
            [
            'group' => 'Healthyvibes',
            'label' => 'Thumbnail',
            'input' => 'image',
            'type' => 'varchar',
            'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required' => false,
            'sort_order' => 2,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'magic_image',
            [
            'group' => 'Healthyvibes',
            'label' => 'Image',
            'input' => 'image',
            'type' => 'varchar',
            'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required' => false,
            'sort_order' => 3,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );

    }
}
