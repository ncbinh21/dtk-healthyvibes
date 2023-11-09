<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

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
