<?php

namespace Healthyvibes\GiaoHangNhanh\Model\Api;

use Healthyvibes\GiaoHangNhanh\Api\UpdateStatusInterface;
use Healthyvibes\GiaoHangNhanh\Model\Carrier\GHN\Express;
use Healthyvibes\GiaoHangNhanh\Model\OrderStatus;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\ResourceModel\Order\Shipment\Track\CollectionFactory as TrackCollectionFactory;
use Psr\Log\LoggerInterface;

class UpdateStatus extends DataObject implements UpdateStatusInterface
{
    /**
     * @var RestRequest
     */
    protected $request;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var OrderFactory
     */
    private OrderFactory $orderFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var TrackCollectionFactory
     */
    private TrackCollectionFactory $trackCollectionFactory;

    /**
     * UpdateStatus constructor.
     * @param RestRequest $request
     * @param EventManager $eventManager
     * @param OrderFactory $orderFactory
     * @param LoggerInterface $logger
     * @param TrackCollectionFactory $trackCollectionFactory
     * @param array $data
     */
    public function __construct(
        RestRequest $request,
        EventManager $eventManager,
        OrderFactory $orderFactory,
        LoggerInterface $logger,
        TrackCollectionFactory $trackCollectionFactory,
        array $data = []
    ) {
        $this->request = $request;
        $this->eventManager = $eventManager;
        $this->orderFactory = $orderFactory;
        $this->logger = $logger;
        $this->trackCollectionFactory = $trackCollectionFactory;
        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    public function handleStatus()
    {
        $this->logger->info('Receive callback ghn start');
        $bodyParams = $this->request->getBodyParams();
        $this->logger->info(json_encode($bodyParams));
        if (empty($bodyParams) || empty($bodyParams['Status']) || empty($bodyParams['OrderCode'])) {
            $this->logger->error('Ghn callback missing Status or OrderCode.');
            throw new LocalizedException(__('Ghn callback missing Status or OrderCode.'));
        }
        $shipment = $this->getShipmentFromTrackingCode($bodyParams['OrderCode']);
        if ($shipment) {
            /** @var Order $order */
            $order = $shipment->getOrder();
            if (in_array($bodyParams['Status'], OrderStatus::STATUS_PREPARING_STORE_LIST)) {
                $order->setState(Order::STATE_PROCESSING);
                $order->setStatus(OrderStatus::STATUS_PREPARING_STORE_CODE);
            } elseif (in_array($bodyParams['Status'], OrderStatus::STATUS_DELIVERY_PROCESSING_LIST)) {
                $order->setState(Order::STATE_PROCESSING);
                $order->setStatus(OrderStatus::STATUS_DELIVERY_PROCESSING_CODE);
            } elseif (in_array($bodyParams['Status'], OrderStatus::STATUS_DELIVERY_FAIL_LIST)) {
                $order->setState(Order::STATE_PROCESSING);
                $order->setStatus(OrderStatus::STATUS_DELIVERY_FAIL_CODE);
            } elseif (in_array($bodyParams['Status'], OrderStatus::STATUS_DELIVERY_ERROR_LIST)) {
                $order->setState(Order::STATE_PROCESSING);
                $order->setStatus(OrderStatus::STATUS_DELIVERY_ERROR_CODE);
            } elseif (in_array($bodyParams['Status'], OrderStatus::STATUS_DELIVERY_COMPLETED_LIST)) {
                if ($order->canInvoice()) {
                    $order->setState(Order::STATE_PROCESSING);
                    $order->setStatus(OrderStatus::STATUS_DELIVERY_COMPLETED_CODE);
                } else {
                    $order->setState(Order::STATE_COMPLETE);
                    $order->setStatus(OrderStatus::STATUS_COMPLETE);
                }
            } else {
                $order->setState(Order::STATE_PROCESSING);
                $order->setStatus(OrderStatus::STATUS_PROCESSING);
            }
            $order->save();
            $this->logger->info('Receive callback ghn done.');
            return true;
        }
        $this->logger->error('Can\'t find shipment on system.');
        throw new LocalizedException(__('Can\'t find shipment on system.'));
    }

    /**
     * @param $trackingCode
     * @return false
     */
    protected function getShipmentFromTrackingCode($trackingCode)
    {
        $tracking = $this->trackCollectionFactory->create()
            ->addFieldToFilter(ShipmentTrackInterface::TRACK_NUMBER, $trackingCode)
            ->addFieldToFilter(ShipmentTrackInterface::CARRIER_CODE, Express::SERVICE_CODE)
            ->getFirstItem();
        return $tracking->getId() ? $tracking->getShipment() : false;
    }
}
