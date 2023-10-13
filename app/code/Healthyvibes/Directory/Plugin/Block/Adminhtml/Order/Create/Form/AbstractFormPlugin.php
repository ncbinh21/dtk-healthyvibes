<?php

namespace Healthyvibes\Directory\Plugin\Block\Adminhtml\Order\Create\Form;

use Magento\Sales\Block\Adminhtml\Order\Create\Form\AbstractForm;
use Healthyvibes\Directory\Block\Adminhtml\Edit\Renderer\City;
use Healthyvibes\Directory\Block\Adminhtml\Edit\Renderer\Ward;

class AbstractFormPlugin
{
    /**
     * @param AbstractForm $subject
     * @param $result
     * @return mixed
     */
    public function afterGetForm(AbstractForm $subject, $result)
    {
        /** @var \Magento\Framework\Data\Form $result */

        if ($result->getElement('ward_id')) {
            $result->getElement('ward_id')->setNoDisplay(true);
        }
        if ($result->getElement('city_id')) {
            $result->getElement('city_id')->setNoDisplay(true);
        }
        if ($result->getElement('ward')) {
            $result->getElement('ward')->setRenderer(
                $subject->getLayout()->createBlock(Ward::class)
            );
        }
        if ($result->getElement('city')) {
            $result->getElement('city')->setRenderer(
                $subject->getLayout()->createBlock(City::class)
            );
        }
        return $result;
    }
}
