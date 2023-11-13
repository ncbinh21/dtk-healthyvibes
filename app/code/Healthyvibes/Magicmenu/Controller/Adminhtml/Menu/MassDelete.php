<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class MassDelete extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $magicmenuIds = $this->getRequest()->getParam('magicmenu');
        if (!is_array($magicmenuIds) || empty($magicmenuIds)) {
            $this->messageManager->addError(__('Please select magicmenu(s).'));
        } else {
            $collection = $this->_magicmenuCollectionFactory->create()
                ->addFieldToFilter('magicmenu_id', ['in' => $magicmenuIds]);
            try {
                foreach ($collection as $item) {
                    $item->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($magicmenuIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
