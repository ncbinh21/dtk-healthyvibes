<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class Delete extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('magicmenu_id');
        try {
            $item = $this->_magicmenuFactory->create()->setId($id);
            $item->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
