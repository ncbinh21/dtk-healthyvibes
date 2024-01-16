<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Controller\Adminhtml\MoneyManagement;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller Upload
 */
class Upload extends Action implements HttpPostActionInterface
{
    /**
     * @var ImageUploader
     */
    protected ImageUploader $imageUploader;

    /** @var PageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ImageUploader $imageUploader
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $resultJson->setData($result);
    }
}
