<?php

namespace Healthyvibes\FacebookChat\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Healthyvibes\FacebookChat\Helper\Data;

/**
 * Class Messenger
 * @package Healthyvibes\FacebookChat\Block
 */
class Messenger extends Template
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Messenger constructor.
     * @param Context $context
     * @param Data $helperData
     */
    public function __construct(
        Context $context,
        Data $helperData
    ) {
        parent::__construct($context);
        $this->helperData = $helperData;
    }
}
