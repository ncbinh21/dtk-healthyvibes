<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model\Money;

use Magento\Framework\Data\OptionSourceInterface;

class Type implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'add', 'label' => __('Add')],
            ['value' => 'minus', 'label' => __('Minus')]
        ];
    }
}
