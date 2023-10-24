<?php

namespace Healthyvibes\Ghtk\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;

class GhtkConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Healthyvibes\Ghtk\Helper\Data
     */
    protected $helperData;

    /**
     * @param \Healthyvibes\Ghtk\Helper\Data $helperData
     */
    public function __construct(
        \Healthyvibes\Ghtk\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        if ($this->helperData->getConfigValue('active') && $this->helperData->getConfigValue('allow_use_insurance')) {
            $config['ghtk'] = [
                'insurance_message' => $this->helperData->getConfigValue('insurance_message'),
                'insurance_amount' => $this->helperData->getConfigValue('insurance_amount')
            ];
        }
        return $config;
    }
}
