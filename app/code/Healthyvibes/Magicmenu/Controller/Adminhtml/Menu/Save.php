<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            $model = $this->_magicmenuFactory->create();
            $storeViewId = $this->getRequest()->getParam('store');

            if ($id = $this->getRequest()->getParam('magicmenu_id')) {
                $model->load($id);
            }

            if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
                /*
                 * Save image upload
                 */
                try {
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => 'image']
                    );
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                    /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();

                    $uploader->addValidateCallback('menu_image', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save(
                        $mediaDirectory->getAbsolutePath('magicmenu/menu/')
                    );
                    $data['image'] = 'magicmenu/menu/'.$result['file'];
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            } else {
                if (isset($data['image']) && isset($data['image']['value'])) {
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } else {
                        $data['image'] = null;
                    }
                }
            }
            /** @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate */
            // $localeDate = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\TimezoneInterface');
            // $data['start_time'] = $localeDate->date($data['start_time'])->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i');
            // $data['end_time'] = $localeDate->date($data['end_time'])->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i');

            if(isset($data['stores'])) $data['stores'] = implode(',', $data['stores']);
            $model->setData($data)
                ->setStoreViewId($storeViewId);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('The Menu menu has been saved.'));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('back') === 'edit') {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'magicmenu_id' => $model->getId(),
                            '_current' => true,
                            'store' => $storeViewId,
                            'current_magicmenu_id' => $this->getRequest()->getParam('current_magicmenu_id'),
                            'saveandclose' => $this->getRequest()->getParam('saveandclose'),
                        ]
                    );
                } elseif ($this->getRequest()->getParam('back') === 'new') {
                    return $resultRedirect->setPath(
                        '*/*/new',
                        ['_current' => TRUE]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the magicmenu.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['magicmenu_id' => $this->getRequest()->getParam('magicmenu_id')]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
