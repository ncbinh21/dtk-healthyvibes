<?php

namespace Healthyvibes\Magicmenu\Model\System\Config;

class Event implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            'click'=>   __('Click'),
            'hover'=>   __('Hover'),
        ];
    }
}
