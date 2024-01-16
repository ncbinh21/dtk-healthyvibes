<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Controller\Adminhtml\MoneyManagement;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller Index
 */
class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Healthyvibes_MoneyManagement::money_item';

    /** @var PageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Healthyvibes_MoneyManagement::money_item');
        $resultPage->getConfig()->getTitle()->prepend(__('Money Management'));
        return $resultPage;
    }
}
