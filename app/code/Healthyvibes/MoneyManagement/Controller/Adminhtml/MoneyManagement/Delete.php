<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Controller\Adminhtml\MoneyManagement;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Healthyvibes_MoneyManagement::delete_money_item';

    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @var MoneyManagementRepositoryInterface
     */
    protected $moneyManagementRepository;

    /**
     * @param Action\Context $context
     * @param RedirectFactory $redirectFactory
     * @param MoneyManagementRepositoryInterface $moneyManagementRepository
     */
    public function __construct(
        Action\Context $context,
        RedirectFactory $redirectFactory,
        MoneyManagementRepositoryInterface $moneyManagementRepository
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->moneyManagementRepository = $moneyManagementRepository;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $moneyManagementId = $this->getRequest()->getParam('id', false);

        if ($moneyManagementId) {
            try {
                $moneyManagementModel = $this->moneyManagementRepository->get((int) $moneyManagementId);
                $this->moneyManagementRepository->delete($moneyManagementModel);
                $this->getMessageManager()->addSuccessMessage(__('The item has been deleted'));
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage(__('Could not delete item with ID ' . $moneyManagementId));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
