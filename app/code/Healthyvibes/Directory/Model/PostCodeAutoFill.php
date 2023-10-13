<?php

namespace Healthyvibes\Directory\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class PostCodeAutoFill implements ConfigProviderInterface
{
    /**
     * @var \Healthyvibes\Directory\Helper\Data
     */
    protected $data;

    /**
     * PostCodeAutoFill constructor.
     * @param \Healthyvibes\Directory\Helper\Data $data
     */
    public function __construct(\Healthyvibes\Directory\Helper\Data $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $result['postcode_auto_fill'] = $this->data->isZipCodeAutofilled();
        return $result;
    }
}
