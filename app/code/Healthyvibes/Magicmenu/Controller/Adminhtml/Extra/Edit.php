<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Extra;

class Edit extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('magicmenu_id');
        $storeViewId = $this->getRequest()->getParam('store');
        $model = $this->_magicmenuFactory->create();

        if ($id) {
            $model->setStoreViewId($storeViewId)->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Extra Menu no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('magicmenu', $model);

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}
