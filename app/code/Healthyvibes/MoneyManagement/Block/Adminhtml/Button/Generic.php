<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Block\Adminhtml\Button;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Button Model Generic
 */
class Generic implements ButtonProviderInterface
{
    /** @var Context */
    protected Context $context;

    /** @var Registry */
    protected Registry $registry;

    /**
     * Generic constructor
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->context = $context;
        $this->registry = $registry;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = [])
    {
        return $this->context->getUrl($route, $params);
    }

    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        return [];
    }

    /**
     * Get context
     *
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }
}
