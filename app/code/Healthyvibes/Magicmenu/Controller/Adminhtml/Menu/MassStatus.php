<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class MassStatus extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $magicmenuIds = $this->getRequest()->getParam('magicmenu');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');
        if (!is_array($magicmenuIds) || empty($magicmenuIds)) {
            $this->messageManager->addError(__('Please select Menu(s).'));
        } else {
            $collection = $this->_magicmenuCollectionFactory->create()
                // ->setStoreViewId($storeViewId)
                ->addFieldToFilter('magicmenu_id', ['in' => $magicmenuIds]);
            try {
                foreach ($collection as $item) {
                    $item->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($magicmenuIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
