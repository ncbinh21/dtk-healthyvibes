<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Controller\Adminhtml\MoneyManagement;

use Exception;
use Magento\Backend\App\Action;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface;
use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterfaceFactory;
use Healthyvibes\MoneyManagement\Api\MoneyManagementRepositoryInterface;

/**
 * Controller save
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Healthyvibes_MoneyManagement::save_money_item';

    /**
     * @var MoneyManagementRepositoryInterface
     */
    protected MoneyManagementRepositoryInterface $moneyManagementRepository;

    /**
     * @var MoneyManagementInterfaceFactory
     */
    protected MoneyManagementInterfaceFactory $moneyManagementInterfaceFactory;

    /** @var ImageUploader */
    protected ImageUploader $imageUploader;

    /**
     * @param Action\Context $context
     * @param MoneyManagementRepositoryInterface $moneyManagementRepository
     * @param MoneyManagementInterfaceFactory $moneyManagementInterfaceFactory
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Action\Context $context,
        MoneyManagementRepositoryInterface $moneyManagementRepository,
        MoneyManagementInterfaceFactory $moneyManagementInterfaceFactory,
        ImageUploader $imageUploader
    ) {
        $this->moneyManagementRepository = $moneyManagementRepository;
        $this->moneyManagementInterfaceFactory = $moneyManagementInterfaceFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $dataPost = $this->getRequest()->getPostValue();
        $id = $this->getRequest()->getParam('entity_id', false);
        try {
            if (!$id) {
                unset($dataPost[MoneyManagementInterface::ENTITY_ID]);
            }
            $dataPost = $this->filterPostData($dataPost);
            $moneyManagement = $this->moneyManagementInterfaceFactory->create();
            $moneyManagement->setData($dataPost);
            $this->moneyManagementRepository->save($moneyManagement);
            if (!empty($moneyManagement->getImage())) {
                $this->imageUploader->moveFileFromTmp($moneyManagement->getImage());
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->getReturnPath((int) ($dataPost[MoneyManagementInterface::ENTITY_ID] ?? ''), $resultRedirect);
        }
        $this->messageManager->addSuccessMessage(__("The item has been saved successfully"));
        if ($this->getRequest()->getParam('stay', false)) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $moneyManagement->getEntityId(), '_current' => true]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Filter data
     *
     * @param array $data
     * @return array
     */
    protected function filterPostData(array $data)
    {
        if ($image = $data['image'] ?? [] && is_array($data['image'])) {
            if (($image['delete'] ?? false) || !$image[0]['name'] ?? false) {
                unset($data['image']);
                return $data;
            }
            $data['image'] = $image[0]['name'];
        }
        return $data;
    }

    /**
     * Get Return Path
     *
     * @param int $id
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    private function getReturnPath(int $id, Redirect &$resultRedirect)
    {
        return $id
            ? $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true])
            : $resultRedirect->setPath('*/*/new');
    }
}
