<?php

namespace Healthyvibes\Directory\Controller\Adminhtml\Address;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Json\Helper\Data;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;
use Healthyvibes\Directory\Helper\Data as DataHelper;

/**
 * Class City
 * @package Healthyvibes\Directory\Controller\Adminhtml\Address
 */
class City extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var Data
     */
    protected Data $jsonHelper;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var DataHelper
     */
    protected DataHelper $dataHelper;

    /**
     * City constructor.
     * @param DataHelper $dataHelper
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Data $jsonHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        DataHelper $dataHelper,
        Context $context,
        PageFactory $resultPageFactory,
        Data $jsonHelper,
        LoggerInterface $logger
    ) {
        $this->dataHelper = $dataHelper;
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|mixed
     */
    public function execute()
    {
        try {
            $data = [];
            if ($regionId = $this->getRequest()->getParam('region_id')) {
                $cities = $this->dataHelper->getListCityFromRegionId($regionId);
                foreach ($cities as $city) {
                    $cityConvert['value'] = $city->getCityId();
                    $cityConvert['text'] = $city->getDefaultName();
                    $data[] = $cityConvert;
                }
            }
            return $this->jsonResponse($data);
        } catch (LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * @param string $response
     * @return mixed
     */
    protected function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
