<?php

namespace Healthyvibes\Magicmenu\Controller\Adminhtml\Extra;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Healthyvibes\Magicmenu\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $fileName = 'extras.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Healthyvibes\Magicmenu\Block\Adminhtml\Extra\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
