<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportXml extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'menus.xml';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Healthyvibes\Magicmenu\Block\Adminhtml\Menu\Grid')->getXml();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
