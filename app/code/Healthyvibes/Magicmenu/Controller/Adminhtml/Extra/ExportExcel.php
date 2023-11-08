<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Extra;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportExcel extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'extras.xls';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Healthyvibes\Magicmenu\Block\Adminhtml\Extra\Grid')->getExcel();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
