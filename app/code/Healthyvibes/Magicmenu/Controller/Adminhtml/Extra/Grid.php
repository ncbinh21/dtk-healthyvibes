<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Extra;

class Grid extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }
}
