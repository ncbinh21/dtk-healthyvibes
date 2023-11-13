<?php

namespace Healthyvibes\Magicmenu\Block\Adminhtml\Extra\Edit\Tab;

use Healthyvibes\Magicmenu\Model\Status;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;

    /**
     * @var \Magento\Catalog\Model\Category\Attribute\Source\Page
     */
    protected $_blocks;

    /**
     * @var \Healthyvibes\Magicmenu\Model\Magicmenu
     */

    protected $_magicmenu;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\DataObjectFactory $objectFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Healthyvibes\Magicmenu\Model\Magicmenu $magicmenu
     * @param \Healthyvibes\Magicmenu\Model\System\Config\Blocks $blocks
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Healthyvibes\Magicmenu\Model\Magicmenu $magicmenu,
        \Healthyvibes\Magicmenu\Model\System\Config\Blocks $blocks,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_magicmenu = $magicmenu;
        $this->_blocks = $blocks;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());

        return $this;
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('magicmenu');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('magic_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Extra Menu Information')]);

        if ($model->getId()) {
            $fieldset->addField('magicmenu_id', 'hidden', ['name' => 'magicmenu_id']);
        }

        $fieldset->addField('name', 'text',
            [
                'label' => __('Name'),
                'title' => __('Name'),
                'name'  => 'name',
                'required' => true,
            ]
        );

        $fieldset->addField('magic_label', 'text',
            [
                'label' => __('Label'),
                'title' => __('Label'),
                'name'  => 'magic_label',
                'after_element_html' => '<p class="nm"><small>Example: New,Hot,...</small></p>',
            ]
        );

        $fieldset->addField('link', 'text',
            [
                'label' => __('Link'),
                'title' => __('Link'),
                'name'  => 'link',
                'required' => true,
                'after_element_html' => '
                <p class="nm"><small>Link for Menu:</small></p>
                <p class="nm"><small>Ex1: http://domain.com/contact</small></p>
                <p class="nm"><small>Ex2: magicproduct/index/product/type/bestseller</small></p>
                <p class="nm"><small>Ex3: bestseller (URL Rewrite)</small></p>
            ',
            ]
        );

        $fieldset->addField('cat_col', 'text',
            [
                'label' => __('Classes'),
                'title' => __('Classes'),
                'name'  => 'cat_col',
                'after_element_html' => '
                <p class="nm"><small>Example: dropdown</small></p>',
                'value' => 'dropdown',
            ]
        );

        $fieldset->addField('ext_content', 'select',
            [
                'label' => __('Extra Content'),
                'title' => __('Extra Content'),
                'name'  => 'ext_content',
                'values' => $this->_blocks->toOptionArray(),
                'after_element_html' => '<p class="nm"><small>Content Dropdown while hover</small></p>',
            ]
        );

        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'stores',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'stores',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }

        $fieldset->addField('order', 'text',
            [
                'label' => __('Order'),
                'title' => __('Order'),
                'name' => 'order',
            ]
        );

        $fieldset->addField('status', 'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $form->addValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getMagicmenu()
    {
        return $this->_coreRegistry->registry('magicmenu');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getMagicmenu()->getId()
            ? __("Edit Extra Menu '%1'", $this->escapeHtml($this->getMagicmenu()->getTitle())) : __('New Extra Menu');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
