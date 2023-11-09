<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class Grid extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }
}
