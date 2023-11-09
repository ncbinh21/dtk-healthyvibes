<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Menu;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'menus.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Healthyvibes\Magicmenu\Block\Adminhtml\Menu\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
