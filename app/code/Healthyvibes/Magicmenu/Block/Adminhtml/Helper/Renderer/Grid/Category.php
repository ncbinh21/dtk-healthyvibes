<?php

namespace Healthyvibes\Magicmenu\Block\Adminhtml\Helper\Renderer\Grid;

class Category extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * block factory.
     *
     * @var \Magento\Cms\Model\BlockFactory
     */
    protected $_categoryFactory;

    /**
     * Category constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_categoryFactory  = $categoryFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $id = $row->getData($this->getColumn()->getIndex()); // $row->getCatId(); // $row->getData('cat_id');
        $category = $this->_categoryFactory->create()->load($id);
        $url = $this->getUrl('catalog/category/edit', ['id' => $id]);

        return '<a href="' . $url . '" alt="' . $url . '" >' . $category->getName() . '</a>';
    }
}
