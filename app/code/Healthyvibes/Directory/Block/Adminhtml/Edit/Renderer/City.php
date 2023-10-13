<?php

namespace Healthyvibes\Directory\Block\Adminhtml\Edit\Renderer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

/**
 * Class City
 * @package Healthyvibes\Directory\Block\Adminhtml\Edit\Renderer
 */
class City extends \Magento\Backend\Block\AbstractBlock implements
    \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $_directoryHelper;

    /**
     * @var SecureHtmlRenderer
     */
    private $secureRenderer;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Healthyvibes\Directory\Helper\Data $directoryHelper,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        $this->_directoryHelper = $directoryHelper;
        parent::__construct($context, $data);
        $this->secureRenderer = $secureRenderer ?? ObjectManager::getInstance()->get(SecureHtmlRenderer::class);
    }

    /**
     * Output the region element and javasctipt that makes it dependent from country element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        if ($country = $element->getForm()->getElement('country_id')) {
            $countryId = $country->getValue();
        } else {
            return $element->getDefaultHtml();
        }

        $cityId = $element->getForm()->getElement('city_id')->getValue();
        $html = '<div class="field field-state admin__field required _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('city', 'city_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select">';
        $html .= '<option value="">' . __('Please select') . '</option>';
        $html .= '</select>';
        $html .= '</div></div>' . "\n";
        return $html;
    }
}
