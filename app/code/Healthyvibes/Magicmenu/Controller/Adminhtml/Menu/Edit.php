<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

class Edit extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('magicmenu_id');
        $storeViewId = $this->getRequest()->getParam('store');
        $model = $this->_magicmenuFactory->create();

        if ($id) {
            $model->setStoreViewId($storeViewId)->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Menu no longer exists.'));
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
