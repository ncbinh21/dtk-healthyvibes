<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class NewAction extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
