<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Controller\Adminhtml\MoneyManagement;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;

/**
 * Edit action
 */
class Edit extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Healthyvibes_MoneyManagement::read_money_item';

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var MoneyManagementRepositoryInterface
     */
    protected MoneyManagementRepositoryInterface $moneyManagementRepository;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param MoneyManagementRepositoryInterface $moneyManagementRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        MoneyManagementRepositoryInterface $moneyManagementRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->moneyManagementRepository = $moneyManagementRepository;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Healthyvibes_MoneyManagement::money_item');
        $moneyManagementId = $this->getRequest()->getParam('id', false);
        if ($moneyManagementId) {
            try {
                $moneyManagementModel = $this->moneyManagementRepository->get((int) $moneyManagementId);
                $resultPage->getConfig()->getTitle()->prepend(
                    $moneyManagementModel->getEntityId() ? $moneyManagementModel->getTitle() : __('New Item')
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage->addBreadcrumb(
            $moneyManagementId ? __('Edit Item %1', $moneyManagementId) : __('New Item'),
            $moneyManagementId ? __('Edit Item %1', $moneyManagementId) : __('New Item')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Money Management'));

        return $resultPage;
    }
}
